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
    $groupId = 0;
    $sqlBuilder = "";
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
        if (isset($_SESSION["_GROUP_"])) {
            $groupId = $stringUtil->RemoveSpecialChar($_SESSION["_GROUP_"]);
        }        

        // Create instances
        $db = new Db();
        $cn = $db->getConnection($systemId);
        $message = new Message($cn);
        $sqlBuilder = new SqlBuilder($systemId, 0, $userId, $groupId);
        $logicAuth = new LogicAuth($cn, $sqlBuilder);

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
        $json = $message->getStatus(1, $logicAuth->getMessage(), $logicAuth->getField());

    } catch (Exception $ex) {
        $json = $message->getStatus(2, $ex->getMessage(), $logicAuth->getField());
    }

    // Return results
    echo $json;
?>