<?php
    // Start session
    session_start();

    // Include classes
    include "page.include.php";

    // General declaration
    $name = "";
    $email = "";
    $msg = "";
    $db = "";
    $stringUtil = "";
    $logicAuth = "";
    $message = "";
    
    // Core code
    try {

        // Create instances
        $db = new Db();
        $message = new Message();
        $stringUtil = new StringUtil();
        $cn = $db->getConnection("");
        $logicAuth = new LogicAuth($cn);

        // Authentication related variables
        if (isset($_REQUEST["_NAME_"])) {
            $name = $stringUtil->RemoveSpecialChar($_REQUEST["_NAME_"]);
        }

        if (isset($_REQUEST["_EMAIL_"])) {
            $email = $stringUtil->RemoveSpecialChar($_REQUEST["_EMAIL_"]);
        }

        // Create new user
        $logicAuth->register($name, $email);

        // Handle return
        if ($logicAuth->getError() == "") {
            $msg = "Cadastro efetuado com sucesso, em breve você receberá um email com as instruções de acesso";
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