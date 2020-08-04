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
    $tableData = "{}";
    $obj = "";
    $table = "";

    // Core code
    try {

        // DB interface
        $db = new Db();       
        $jsonUtil = new JsonUtil();

        // Open connection
        $cn = $db->getConnection();        

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder($_SESSION["_SYSTEM_"], 
                                     $_SESSION["_TABLE_"], 
                                     $_SESSION["_USER_"], 
                                     $_SESSION["_LANGUAGE_"]);

        // Get table structure
        $tableDef = $sqlBuilder->getTableDef($cn, "json");
           
        // Read form
        foreach($tableDef as $item) {

            $tableName = $item["table_name"];
            $fieldName = $item["field_name"];

            if ($_SESSION["_EVENT_"] != "Delete") {
                $fieldValue = $_REQUEST[$fieldName];
                $tableData = $jsonUtil->setValue($tableData, $fieldName, $fieldValue);
            }
        }


        // Reset id_system 
        $tableData = $jsonUtil->setValue($tableData, "id_system", $_SESSION["_SYSTEM_"]);

        // Open transaction
        pg_query($cn, "begin");

            // Persist info
            $db->setSystem($_SESSION["_SYSTEM_"]);
            $db->setLastId($_SESSION["_ID_"]);
            $db->setEvent($_SESSION["_EVENT_"]);
            $id = $db->persist($cn, $tableName, $tableData);

            // Create physical table
            if ($_SESSION["_EVENT_"] == "New") {
                if ($tableName == "tb_table") {

                    $obj = json_decode($tableData);
                    $table = $obj->{'name'};

                    pg_query($cn, "drop table if exists " . $table);
                    pg_query($cn, "create table if not exists " . $table . " (id serial, field jsonb);");
                }
            }

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