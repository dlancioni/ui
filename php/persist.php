<?php
    // Start session
    session_start();

    // Include classes
    include "include.php";

    // General declaration
    $db = "";
    $tableDef = "";
    $sqlBuilder = "";
    $jsonUtil = "";
    $json = "{}";
    $output = "";
    $tableName = "";
    $data = "";

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
            $json = $jsonUtil->setValue($json, $fieldName, $fieldValue);
        }

        $json = $_REQUEST["_FORM_DATA_"];

    } catch (Exception $ex) {        
        $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
    } finally {

    }

    echo $json;
?>