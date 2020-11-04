<?php
    // Start session
    session_start();

    // Include classes
    include "include.php";

    // General declaration
    $rs = "";
    $db = "";
    $cn = "";
    $sql = "";
    $json = "";
    $jsonUtil = "";

    // Sign in info
    $systemId = 0;
    $username = "";
    $password = "";
    $stringUtil = new StringUtil();    
    
    // Core code
    try {

        // Authentication related variables
        if (isset($_REQUEST["_SYSTEM_"])) {
            if (trim($_REQUEST["_SYSTEM_"]) != "") {
                $systemId = $stringUtil->RemoveSpecialChar($_REQUEST["_SYSTEM_"]);
            }
        }

        if (isset($_REQUEST["_USERNAME_"])) {
            $username = $stringUtil->RemoveSpecialChar($_REQUEST["_USERNAME_"]);
        }

        if (isset($_REQUEST["_PASSWORD_"])) {
            $password = $stringUtil->RemoveSpecialChar($_REQUEST["_PASSWORD_"]);
        }


        // DB interface
        $db = new Db();
        $cn = $db->getConnection($_REQUEST["_SYSTEM_"]);
        $jsonUtil = new JsonUtil();        
        $sqlBuilder = new SqlBuilder($systemId, 0, 0, 0);
        $message = new Message($cn, $sqlBuilder);
        $logicAuth = new LogicAuth($cn, $sqlBuilder);

        /*
         * Validate the system id
         */
        $sql = "";
        $sql .= " select schema_name from information_schema.schemata";
        $sql .= " where schema_name = " . "'" . trim($systemId) . "'";

        $rs = pg_query($cn, $sql);
        if (!pg_fetch_row($rs)) {
            throw new Exception("Cód. Assinante não encontrado");
        }

        // Authenticate user
        $logicAuth->authenticate($systemId, $username, $password);

        // Handle results
        if ($logicAuth->authenticated == 1) {

            // Success
            $json = $message->getStatus(1, $logicAuth->message);

            // Keep sessioninfo
            $_SESSION["_AUTH_"] = $logicAuth->authenticated;
            $_SESSION["_USER_"] = $logicAuth->userId;
            $_SESSION["_USERNAME_"] = $logicAuth->userName;
            $_SESSION["_GROUP_"] = $logicAuth->groupId;
            $_SESSION["_SYSTEM_"] = $systemId;
            $_SESSION["_MENU_"] = $logicAuth->menu;
            $_SESSION['_TABLE_'] = "0";
            $_SESSION['_PAGE_EVENT_'] = "";
            $_SESSION['_TABLEDEF_'] = "";

        } else {

            // Fail
            $json = $message->getStatus(2, $logicAuth->message);

            // Can navigate but not authenticated
            $_SESSION["_AUTH_"] = 0;
            $_SESSION["_USER_"] = 0;
            $_SESSION["_USERNAME_"] = "";
            $_SESSION["_GROUP_"] = 0;
            $_SESSION["_SYSTEM_"] = 0;
            $_SESSION["_MENU_"] = "";
        }

    } catch (Exception $ex) {

        // No data on error
        $json = $message->getStatus(2, $ex->getMessage());
    }

    // Close connection
    if ($cn) {
        pg_close($cn); 
    }    

    // Return results
    echo $json;
?>