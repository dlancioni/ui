<?php
    // Start session
    session_start();

    // Include classes
    include "include.php";

    // General declaration
    $db = "";
    $cn = "";
    $json = "";
    $jsonUtil = "";

    // Sign in info
    $signId = 0;
    $username = "";
    $password = "";
    $msg = "";
    
    // Core code
    try {

        // Authentication related variables
        if (isset($_REQUEST["_SIGNID_"])) {
            $signId = $_REQUEST["_SIGNID_"];
        }
        if (isset($_REQUEST["_SIGNID_"])) {
            $username = $_REQUEST["_USERNAME_"];
        }
        if (isset($_REQUEST["_SIGNID_"])) {
            $password = $_REQUEST["_PASSWORD_"];
        }    

        // DB interface
        $db = new Db();       
        $jsonUtil = new JsonUtil();
        $cn = $db->getConnection();

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder($_SESSION["_SYSTEM_"], 
                                     $_SESSION["_TABLE_"], 
                                     $_SESSION["_USER_"],
                                     $_SESSION["_GROUP_"]);
        $message = new Message($cn, $sqlBuilder);                                     

        // Authenticate user
        $logicAuth = new LogicAuth($cn, $sqlBuilder);
        $logicAuth->authenticate($signId, $username, $password);

        // Handle results
        if ($logicAuth->authenticated == 1) {

            // Success
            $msg = $message->getValue("A16");
            $json = $message->getStatus(1, $msg);            

            // Keep sessioninfo
            $_SESSION["_AUTH_"] = 1;
            $_SESSION['_USER_'] = 22;
            $_SESSION['_GROUP_'] = 2;

        } else {

            // Fail
            $msg = $logicAuth->error;
            $json = $message->getStatus(2, $msg);

            // Keep sessioninfo
            $_SESSION["_AUTH_"] = 0;  // No 
            $_SESSION['_USER_'] = 1;  // public 
            $_SESSION['_GROUP_'] = 2; // public
        }

    } catch (Exception $ex) {

        // No data on error
        $msg = $ex->getMessage();
        $json = $message->getStatus(2, $msg);

    } finally {

        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }

    // Return results
    echo $json;
?>