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
    $tableDef = "";
    $sqlBuilder = "";
    $jsonUtil = "";
    $old = "{}";
    $new = "{}";
    $logic = "";
    $fieldName = "";
    $fieldType = "";
    $fieldUnique = "";
    $changed = false;

    // Core code
    try {
        
        // Object instances
        $jsonUtil = new JsonUtil();
        $numberUtil = new NumberUtil();

        // DB interface
        $db = new Db();       
        $db->setSystem($_SESSION["_SYSTEM_"]);
        $db->setLastId($_SESSION["_ID_"]);
        $db->setEvent($_SESSION["_EVENT_"]);
        $db->setTable($_SESSION["_TABLE_"]);

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder($_SESSION["_SYSTEM_"], 
                                     $_SESSION["_TABLE_"], 
                                     $_SESSION["_USER_"], 
                                     $_SESSION["_LANGUAGE_"]);

        // Open connection
        $cn = $db->getConnection();

        // Get table structure
        $tableDef = $sqlBuilder->getTableDef($cn, "json");
        if ($tableDef) {
            $tableName = $tableDef[0]["table_name"];
        }

        // Get exiting record
        if ($db->getEvent() == "Edit" || $db->getEvent() == "Delete") {
            $sql = "";
            $sql .= " select field from " . $tableName;
            $sql .= " where " . $jsonUtil->condition($tableName, "id", "int", "=", $db->getLastId());
            if ($tableName != "tb_system") {
                $sql .= " and " . $jsonUtil->condition($tableName, "id_system", "int", "=", $db->getSystem());
            }
            $rs = $db->query($cn, $sql);
            while ($row = pg_fetch_row($rs)) {
                $old = $row[0];
                $new = $row[0];
            };
        }
           
        // Read form
        foreach($tableDef as $item) {

            $fieldName = $item["field_name"];
            $fieldType = $item["data_type"];

            if (isset($_REQUEST[$fieldName])) {
            
                $fieldValue = $_REQUEST[$fieldName];
                if ($fieldType == "float") {
                    $fieldValue = $numberUtil->valueOf($_SESSION["_LANGUAGE_"], $fieldValue);
                }
                $new = $jsonUtil->setValue($new, $fieldName, $fieldValue);
            }
        }

        // Validate unique fields (when changed)
        if ($db->getEvent() == "New" || $db->getEvent() == "Edit") {
            foreach($tableDef as $item) {

                $fieldName = $item["field_name"];
                $fieldType = $item["data_type"];
                $fieldUnique = $item["field_unique"];
                $fieldValue = $jsonUtil->getValue($new, $fieldName);
    
                if ($jsonUtil->getValue($old, $fieldName, true) != 
                    $jsonUtil->getValue($new, $fieldName, true)) {

                    // Control if record changed    
                    $changed = true;
    
                    // Avoid changing unique value
                    if ($fieldUnique == 1) {
                        $sql = "";
                        $sql .= " select field from " . $tableName;
                        $sql .= " where " . $jsonUtil->condition($tableName, $fieldName, "text", "=", $fieldValue);
                        if ($tableName != "tb_system") {
                            $sql .= " and " . $jsonUtil->condition($tableName, "id_system", "int", "=", $db->getSystem());
                        }
                        $rs = $db->query($cn, $sql);
                        while ($row = pg_fetch_row($rs)) {
                            throw new Exception("$fieldValue already exists");
                        };                        
                    }
                }
            }

            if ($changed == false)  {
                throw new Exception("No changes in current records");
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
                $logic->before($old, $new);

            // Persist info
            $id = $db->persist($cn, $tableName, $new);

            // After insert logic
            if ($logic)
                $logic->after($id, $old, $new);

        // Open transaction
        pg_query($cn, "commit");

        // Set final id
        $db->setLastId($id);

    } catch (Exception $ex) {

        // Keep the error
        $db->setError("Persist()", $ex->getMessage());

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