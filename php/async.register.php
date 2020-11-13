<?php
    // Start session
    session_start();

    // Include classes
    include "page.include.php";

    // General declaration
    $name = "";
    $email = "";
    $msg = "";
    $stringUtil = new StringUtil();
    $logicAuth = new LogicAuth();
    $message = new Message();  
    
    // Core code
    try {

        // Authentication related variables
        if (isset($_REQUEST["_NAME_"])) {
            $name = $stringUtil->RemoveSpecialChar($_REQUEST["_NAME_"]);
        }

        if (isset($_REQUEST["_EMAIL_"])) {
            $email = $stringUtil->RemoveSpecialChar($_REQUEST["_EMAIL_"]);
        }

        // Create new user
        $logicAuth->register($name, $email);

        // Success, good news to user
        $msg = "Cadastro efetuado com sucesso, em breve você receberá um email com as instruções de acesso";

        // No data on error
        $json = $message->getStatus(1, $msg);        

    } catch (Exception $ex) {

        // No data on error
        $json = $message->getStatus(2, $ex->getMessage());
    }

    // Return results
    echo $json;
?>