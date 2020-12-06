<?php
    // Start session
    session_start();

    // Include classes
    include "../page/include.php";

    // General declaration
    $db = "";
    $cn = "";
    $msg = "";
    $json = "";    

    // Sign in info
    $systemId = "";
    $username = "";
    $password = "";
    $email = "";
    $stringUtil = new StringUtil();
    
    // Core code
    try {

        // Authentication related variables
        if (isset($_REQUEST["_EMAIL_"])) {
            $email = $stringUtil->RemoveSpecialChar($_REQUEST["_EMAIL_"]);
        }        

        // DB interface
        $db = new Db();
        $cn = $db->getConnection($systemId);
        $sqlBuilder = new SqlBuilder($systemId, 0, 0, 0);
        $message = new Message($cn);
        $logicAuth = new LogicAuth($cn, $sqlBuilder);

        // Authenticate user
        $logicAuth->retrieveCredential($systemId, $email);

        // No data on error
        if ($logicAuth->getError() == "") {
            $msg .= "Solicitacao executada com sucesso, ";
            $msg .= "em breve você receberá um email com as instruções para acesso.";
            $json = $message->getStatus(1, $msg);
        } else {
            $json = $message->getStatus(2, $logicAuth->getError());
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