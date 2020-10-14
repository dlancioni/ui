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
    $tableName = "tb_system";
    $total = 0;
    
    // Core code
    try {

        // Open connection
        $db = new Db();
        $cn = $db->getConnection();
        $logicSetup = new LogicSetup($cn);
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