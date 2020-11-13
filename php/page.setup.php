<?php

    // Include classes
    include "include.php";

    // General declaration
    $db = "";
    $cn = "";
    $rs = "[]";
    $sql = "";
    $json = "";
    $jsonUtil = "";
    $sqlBuilder = "";
    $total = 0;
    $systemId = "forms";
    
    // Core code
    try {

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder(1, 0, 0, 0);

        // Open connection
        $db = new Db();
        $cn = $db->getConnection(""); // No schema yet
        $logicSetup = new LogicSetup($cn, $sqlBuilder);
        $logicSetup->setup($systemId);

        echo "Done !!";

    } catch (Exception $ex) {        

        // Handle error
        throw $ex;
    }

    // Close connection
    if ($cn) {
        pg_close($cn); 
    }    
?>