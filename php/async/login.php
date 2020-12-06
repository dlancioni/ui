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
    $jsonUtil = "";

    // Sign in info
    $systemId = "";
    $username = "";
    $password = "";
    $email = "";
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
        $cn = $db->getConnection($systemId);
        $jsonUtil = new JsonUtil();
        $sqlBuilder = new SqlBuilder($systemId, 0, 0, 0);
        $message = new Message($cn);
        $logicAuth = new LogicAuth($cn, $sqlBuilder);

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
            $_SESSION['_PAGE_ACTION_'] = "";
            $_SESSION['_TABLEDEF_'] = "";
            $_SESSION['_VIEWDEF_'] = "";

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