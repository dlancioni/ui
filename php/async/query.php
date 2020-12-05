<?php
    // Start session
    session_start();

    // Include classes
    include "../page/include.php";

    // General declaration
    $db = "";
    $cn = "";
    $rs = "[]";
    $sql = "";
    $json = "";
    $jsonUtil = "";
    
    // Core code
    try {

        // Request query
        $sql = $_REQUEST["param"];

        // DB interface
        $db = new Db();       
        $jsonUtil = new JsonUtil();

        // Open connection
        $cn = $db->getConnection($_SESSION["_SYSTEM_"]);

        // Get data
        $rs = $db->queryJson($cn, $sql);

        // Par string
        $json = json_encode($rs, JSON_UNESCAPED_UNICODE);

    } catch (Exception $ex) {        

        // No data on error
        $json = "[]";
    }

    // Close connection
    if ($cn) {
        pg_close($cn); 
    }    

    // Return results
    echo $json;
?>