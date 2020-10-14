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
    
    // Core code
    try {

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder(1, 1, 0, 1);

        // Open connection
        $db = new Db();
        $cn = $db->getConnection();
        $logicSetup = new LogicSetup($cn, $sqlBuilder);
        $logicSetup->setup(1);

        echo "Done !!";

    } catch (Exception $ex) {        

        // Handle error
        throw $ex;

    } finally {

        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }
?>