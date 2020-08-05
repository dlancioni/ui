<?php
    // Start session
    session_start();

    // Include classes
    include "include.php";

    // General declaration
    $id = 0;
    $db = "";
    $cn = "";
    $tableDef = "";
    $sqlBuilder = "";
    $jsonUtil = "";
    $record = "{}";
    $logic = "";

    // Core code
    try {
        
        // Object instances
        $jsonUtil = new JsonUtil();

        // DB interface
        $db = new Db();       
        $db->setSystem($_SESSION["_SYSTEM_"]);
        $db->setLastId($_SESSION["_ID_"]);
        $db->setEvent($_SESSION["_EVENT_"]);

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder($_SESSION["_SYSTEM_"], 
                                     $_SESSION["_TABLE_"], 
                                     $_SESSION["_USER_"], 
                                     $_SESSION["_LANGUAGE_"]);

        // Open connection
        $cn = $db->getConnection();

        // Get table structure
        $tableDef = $sqlBuilder->getTableDef($cn, "json");
           
        // Read form
        foreach($tableDef as $item) {

            $tableName = $item["table_name"];
            $fieldName = $item["field_name"];

            if ($_SESSION["_EVENT_"] != "Delete") {
                $fieldValue = $_REQUEST[$fieldName];
                $record = $jsonUtil->setValue($record, $fieldName, $fieldValue);
            }
        }

        // Get logic for current transaction
        switch ($tableName) {
            case "tb_table":
                $logic = new TableLogic($cn, $sqlBuilder, $db);
                break;                
            default:  
                $logic  = "";
        }

        // Open transaction
        pg_query($cn, "begin");

            // Before insert logic 
            if ($logic)
                $logic->before($record);

            // Persist info
            $id = $db->persist($cn, $tableName, $record);

            // After insert logic
            if ($logic)
                $logic->after($id, $record);

        // Open transaction
        pg_query($cn, "commit");        

    } catch (Exception $ex) {        

        // Open transaction
        pg_query($cn, "rollback");

    } finally {

        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }

    // Return results
    if ($db->getError() != "") {
        echo $db->getError();
    } else {
        echo $db->getMessage();        
    }

?>