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

    // Core code
    try {

        // Create instances
        $db = new Db();        
        $cn = $db->getConnection("");
        $logicAuth = new LogicAuth($cn);
        $message = new Message($cn);
        $stringUtil = new StringUtil();    

        // Authentication related variables
        if (isset($_REQUEST["current"])) {
            $current = $stringUtil->RemoveSpecialChar($_REQUEST["current"]);
        }

        if (isset($_REQUEST["new"])) {
            $new = $stringUtil->RemoveSpecialChar($_REQUEST["new"]);
        }

        if (isset($_REQUEST["confirm"])) {
            $confirm = $stringUtil->RemoveSpecialChar($_REQUEST["confirm"]);
        }        

        // Create new user
        $logicAuth->changePassword($current, $new, $confirm);

        // Handle return
        if ($logicAuth->getError() == "") {
            $msg = $message->getValue("M26");
            $json = $message->getStatus(1, $msg);
        } else {
            $msg = $logicAuth->getError();
            $json = $message->getStatus(1, $msg);            
        }

    } catch (Exception $ex) {
        $json = $message->getStatus(2, $ex->getMessage());
    }

    // Close connection
    if ($cn) {
        pg_close($cn); 
    }    

    // Return results
    echo $json;
?>