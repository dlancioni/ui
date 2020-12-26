<?php
    // Start session
    session_start();

    // Include classes
    include "../page/include.php";

    // General declaration
    $db = "";
    $cn = "";
    $sql = "";
    $json = "";
    $msg = "";
    $error = "";
    $email = "";
    $token = "";    
    $systemId = "";
    $username = "";
    $password = "";
    $jsonUtil = "";
    $stringUtil = new StringUtil();
    
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
        $cn = $db->getConnection($systemId);
        $jsonUtil = new JsonUtil();
        $sqlBuilder = new SqlBuilder($systemId, 0, 0, 0);
        $message = new Message($cn);
        $logicAuth = new LogicAuth($cn, $sqlBuilder);

        // Current user to control unique login
        $token = strtoupper($systemId . "_" . $username);

        if (isset($_GLOBAL[$token])) {
            if ($_GLOBAL[$token] == $token) {
                $error = $message->getValue("M29", $username);
                throw new Exception($error);
            }
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
            $_SESSION['_MODULE_'] = "0";
            $_SESSION['_PAGE_ACTION_'] = "";
            $_SESSION['_TABLEDEF_'] = "";
            $_SESSION['_VIEWDEF_'] = "";

            // Control unique access
            $_GLOBAL[$token] = $token;

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