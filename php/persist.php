<?php
    // Start session
    session_start();

    // Include classes
    include "include.php";

    // General declaration
    $db = "";
    $cn = "";
    $tableDef = "";
    $sqlBuilder = "";
    $jsonUtil = "";
    $tableData = "{}";

    // Core code
    try {

        // DB interface
        $db = new Db();
        $jsonUtil = new JsonUtil();

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder($_SESSION["_SYSTEM_"], 
                                     $_SESSION["_TABLE_"], 
                                     $_SESSION["_USER_"], 
                                     $_SESSION["_LANGUAGE_"]);
        // Get table structure
        $tableDef = $sqlBuilder->getTableDef("json");

        // Generate json to be persisted
        foreach($tableDef as $item) {
            $tableName = $item["table_name"];
            $fieldName = $item["field_name"];
            $fieldValue = $_REQUEST[$fieldName];
            $tableData = $jsonUtil->setValue($tableData, $fieldName, $fieldValue);
        }

        // Open connection
        $cn = $db->getConnection();

        // Open transaction
        pg_query($cn, "begin");

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
    echo $tableData;
?>