<?php
    // Start session
    session_start();

    // Include classes
    include "../page/include.php";

    // General declaration
    $db = "";
    $msg = "";
    $current = "";
    $new = "";
    $confirm = "";   
    $message = "";
    $logicAuth = "";
    $stringUtil = "";
    $systemId = "";
    $userId = 0;
    $stringUtil = new StringUtil();
    
    // Core code
    try {

        // Get data from session
        if (isset($_SESSION["_SYSTEM_"])) {
            $systemId = $stringUtil->RemoveSpecialChar($_SESSION["_SYSTEM_"]);
        }
        if (isset($_SESSION["_USER_"])) {
            $userId = $stringUtil->RemoveSpecialChar($_SESSION["_USER_"]);
        }

        // Create instances
        $db = new Db();
        $cn = $db->getConnection($systemId);
        $logicAuth = new LogicAuth($cn);
        $message = new Message($cn);

        // Authentication related variables
        if (isset($_REQUEST["_CURRENT_"])) {
            $current = $stringUtil->RemoveSpecialChar($_REQUEST["_CURRENT_"]);
        }
        if (isset($_REQUEST["_NEW_"])) {
            $new = $stringUtil->RemoveSpecialChar($_REQUEST["_NEW_"]);
        }
        if (isset($_REQUEST["_CONFIRM_"])) {
            $confirm = $stringUtil->RemoveSpecialChar($_REQUEST["_CONFIRM_"]);
        }

        // Create new user
        $logicAuth->changePassword($userId, $current, $new, $confirm);

        // Success
        $json = $message->getStatus(1, $logicAuth->message);

    } catch (Exception $ex) {
        $json = $message->getStatus(2, $ex->getMessage());
    }

    // Return results
    echo $json;
?>