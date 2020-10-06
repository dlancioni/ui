<?php
    // Start session
    session_start();

    // Include classes
    include "include.php";

    // General declaration
    $id = 0;
    $db = "";
    $cn = "";
    $rs = "";
    $sql = "";
    $old = "{}";
    $new = "{}";    
    $key = "";       
    $logic = "";
    $message = "";
    $tableDef = "";
    $tableName = "";
    $jsonUtil = "";
    $unique = "";    
    $tableId = 0;
    $event = "";
    $fieldName = "";       
    $fieldType = "";
    $sqlBuilder = "";    
    $fieldUnique = "";
    $fieldLabel = "";    
    $changed = false;
    $file = "";

    // Core code
    try {

        // Open connection
        $db = new Db();
        $cn = $db->getConnection();                

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder($_SESSION["_SYSTEM_"], 
                                     $_SESSION["_TABLE_"], 
                                     $_SESSION["_USER_"],
                                     $_SESSION["_GROUP_"]);

        $sqlBuilder->setLastId($_SESSION["_ID_"]);
        $sqlBuilder->setEvent($_SESSION["_EVENT_"]);
        $tableId = $_SESSION["_TABLE_"];        

        // Object instances
        $jsonUtil = new JsonUtil();
        $stringUtil = new StringUtil();
        $numberUtil = new NumberUtil();
        $message = new Message($cn, $sqlBuilder);

        // Get table structure
        $tableDef = $sqlBuilder->getTableDef($cn, $tableId);
        if ($tableDef) {
            $tableName = $tableDef[0]["table_name"];
            $event = $_SESSION["_EVENT_"];            
        }

        // Rules for update/delete
        if ($event == "Edit" || $event == "Delete") {

            // Get existing record
            $filter = new Filter();
            $filter->add($tableName, "id", $sqlBuilder->getLastId());
            $data = $sqlBuilder->executeQuery($cn, $tableId, $filter->create(), $sqlBuilder->QUERY_NO_JOIN);
            if (count($data) > 0) {
                $old = json_encode($data[0]);
                $old = $stringUtil->RemoveSpecialChar($old);
                $new = $old;
            }

            // Cannot touch system info
            if ($jsonUtil->getValue($old, "id_group", true) == "1") {
                $msg = $message->getValue("A11", $key);
                throw new Exception($msg);
            }            
        }

        // Handle files
        if (count($_FILES) > 0) {
            $logicUpload = new LogicUpload($cn, $sqlBuilder);
            $logicUpload->uploadFiles($_FILES);
        }
        
        // Read form
        foreach($tableDef as $item) {

            // Read base fields
            $fieldName = $item["field_name"];
            $fieldType = $item["data_type"];

            // Get form info
            if (isset($_REQUEST[$fieldName])) {
                $fieldValue = $_REQUEST[$fieldName];
                if ($fieldType == "float") {
                    $fieldValue = $numberUtil->valueOf($fieldValue);
                }
                $fieldValue = $stringUtil->RemoveSpecialChar($fieldValue);
                $new = $jsonUtil->setValue($new, $fieldName, $fieldValue);
            }

            // Get file info
            if (isset($_FILES[$fieldName])) {
                $fieldValue = $_FILES[$fieldName]["name"];
                $fieldValue = $stringUtil->RemoveSpecialChar($fieldValue);
                $new = $jsonUtil->setValue($new, $fieldName, $fieldValue);
            }


        }

        // Validate unique fields (when changed)
        if ($event == "New" || $event == "Edit") {
            $filter = new Filter();
            foreach ($tableDef as $item) {
                $fieldLabel = $item["field_label"];
                $fieldName = $item["field_name"];
                $fieldType = $item["data_type"];
                $fieldUnique = $item["field_unique"];
                $fieldValue = $jsonUtil->getValue($new, $fieldName);   
                if ($jsonUtil->getValue($old, $fieldName, true) != 
                    $jsonUtil->getValue($new, $fieldName, true)) {
                    $changed = true;
                    if ($fieldUnique == 1) {
                        $filter->addCondition($tableName, $fieldName, $fieldType, "=", $fieldValue);
                        $key .= $fieldLabel . ", ";
                    }                    
                }
            }

            // Do nothing if no changes in the records
            if ($changed == false)  {
                $msg = $message->getValue("A5");
                throw new Exception($msg);
            }

            // Check if values already exists
            if ($filter->create() != "[]") {
                $data = $sqlBuilder->executeQuery($cn, $tableId, $filter->create(), $sqlBuilder->QUERY_NO_JOIN);
                if (count($data) > 0) {
                    $key =  rtrim($key, ", ");
                    $msg = $message->getValue("A4", $key);
                    throw new Exception($msg);
                }
            }
        }

        // Get logic for current transaction
        switch ($tableName) {
            case "tb_table":
                $logic = new LogicTable($cn, $sqlBuilder);
                break;                
            case "tb_field":
                $logic = new LogicField($cn, $sqlBuilder);
                break;
            case "tb_event":
                $logic = new LogicEvent($cn, $sqlBuilder);
                break;
            default:  
                $logic  = "";
        }

        // Open transaction
        pg_query($cn, "begin");

            // Before insert logic 
            if ($logic)
                $logic->before($old, $new);

            // Persist info
            $id = $sqlBuilder->persist($cn, $tableName, $new);

            // After insert logic
            if ($logic)
                $logic->after($id, $old, $new);

        // Open transaction
        pg_query($cn, "commit");

        // Set final id
        $sqlBuilder->setLastId($id);

    } catch (Exception $ex) {

        // Keep the error
        $sqlBuilder->setError("Persist()", $ex->getMessage());

        // Open transaction
        pg_query($cn, "rollback");

    } finally {

        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }

    // Return results
    if ($sqlBuilder->getError() != "") {
        echo $sqlBuilder->getError();
    } else {
        echo $sqlBuilder->getMessage();        
    }
?>