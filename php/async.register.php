<?php
    // Start session
    session_start();

    // Include classes
    include "page.include.php";

    // General declaration
    $name = "";
    $email = "";
    $stringUtil = new StringUtil();
    $logicAuth = new LogicAuth("", "");
    
    // Core code
    try {

        // Authentication related variables
        if (isset($_REQUEST["_NAME_"])) {
            $name = $stringUtil->RemoveSpecialChar($_REQUEST["_NAME_"]);
        }

        if (isset($_REQUEST["_EMAIL_"])) {
            $email = $stringUtil->RemoveSpecialChar($_REQUEST["_EMAIL_"]);
        }

        $logicAuth->register($name, $email);

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