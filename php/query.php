<?php
    // Start session
    session_start();

    // Include classes
    include "include.php";

    // General declaration
    $db = "";
    $cn = "";
    $jsonUtil = "";
    $rs = "[]";
    $sql = "";
    $json = "";

    // Core code
    try {

        // Request query
        $sql = $_REQUEST["sql"];

        // DB interface
        $db = new Db();       
        $jsonUtil = new JsonUtil();

        // Open connection
        $cn = $db->getConnection();        

        // Get data
        $rs = $db->queryJson($cn, $sql);

        // Par string
        $json = json_encode($rs);

    } catch (Exception $ex) {        

        // No data on error
        $json = "[]";

    } finally {

        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }

    // Return results
    echo $json;
?>