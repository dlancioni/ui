<?php

    // Include classes
    include "include.php";

    // General declaration
    $db = "";
    $cn = "";
    $systemId = "forms";
    
    // Core code
    try {

        // Open connection
        $db = new Db();
        $cn = $db->getConnection("");
        $logicSetup = new LogicSetup($cn);
        $logicSetup->setup($systemId);

    } catch (Exception $ex) {        

        // Handle error
        throw $ex;
    }

    // Close connection
    if ($cn) {
        pg_close($cn); 
    }    
?>