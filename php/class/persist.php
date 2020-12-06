<?php
    class Persist extends Base {

        function __construct() {
        }

        /* 
         * Send mail to destination
         */
        public function save($session) {

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
            $output = "";
            $action = "";
            $fieldName = "";       
            $fieldType = "";
            $sqlBuilder = "";    
            $fieldUnique = "";
            $fieldLabel = "";    
            $changed = false;
            $file = "";
            $systemId = "";
            $tableId = 0;
            $viewId = 0;
            $userId = 0;
            $groupId = 0;

            // Core code
            try {
                
                // Handle System
                if (isset($session["_SYSTEM_"])) {
                    $this->setSystem($session["_SYSTEM_"]);
                }                
                // Handle Table
                if (isset($session["_TABLE_"])) {
                    $this->setTable($session["_TABLE_"]);
                }
                // Handle User
                if (isset($session["_USER_"])) {
                    $this->setUser($session["_USER_"]);
                }
                // Handle Group
                if (isset($session["_GROUP_"])) {
                    $this->setGroup($session["_GROUP_"]);
                }
                // Handle ID    
                if (isset($session["_ID_"])) {
                    $this->setLastId($session["_ID_"]);
                } else {
                    $this->setLastId("0");            
                }
                // Handle Action
                if (isset($session["_ACTION_"])) {
                    $this->setAction($session["_ACTION_"]);
                }

                // Validate properties above
                // Pending yet

                // To simplify and debug, keep in variables
                $systemId = $this->getSystem();
                $tableId = $this->getTable();
                $userId = $this->getUser();
                $groupId = $this->getGroup();
                $action = $this->getAction();

                // Open connection
                $db = new Db();
                $cn = $db->getConnection($systemId);

                // Object instances
                $jsonUtil = new JsonUtil();
                $stringUtil = new StringUtil();
                $numberUtil = new NumberUtil();
                $message = new Message($cn);                
                $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $groupId);

                // Get table structure
                $tableDef = $sqlBuilder->getTableDef($cn, $tableId, $viewId);
                if ($tableDef) {
                    $tableName = $tableDef[0]["table_name"];
                }

                // Rules for update/delete
                if ($action == "Edit" || $action == "Delete") {

                    // Get existing record
                    $filter = new Filter();
                    $filter->add($tableName, "id", $sqlBuilder->getLastId());
                    $data = $sqlBuilder->executeQuery($cn, $tableId, $viewId, $filter->create(), $sqlBuilder->QUERY_NO_JOIN);
                    if (count($data) > 0) {
                        $old = json_encode($data[0]);
                        $old = $stringUtil->RemoveSpecialChar($old);
                        $new = $old;
                    }

                    // Cannot touch system info
                    if ($sqlBuilder->getGroup() > 1) {
                        if ($jsonUtil->getValue($old, "id_group", true) == "1") {
                            $msg = $message->getValue("A11", $key);
                            throw new Exception($msg);
                        }
                    }
                }

                // Handle files
                if (count($_FILES) > 0) {
                    $logicUpload = new LogicUpload($cn);
                    $logicUpload->uploadFiles($_FILES);
                }
                
                // Read form
                foreach($tableDef as $item) {

                    // Read base fields
                    $fieldName = $item["field_name"];
                    $fieldType = $item["field_type"];

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
                        if (trim($fieldValue) != "") {
                            $new = $jsonUtil->setValue($new, $fieldName, $fieldValue);
                        }
                    }
                }

                // Validate unique fields (when changed)
                if ($action == "New" || $action == "Edit") {
                    $filter = new Filter();
                    foreach ($tableDef as $item) {
                        $fieldLabel = $item["field_label"];
                        $fieldName = $item["field_name"];
                        $fieldType = $item["field_type"];
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
                        $data = $sqlBuilder->executeQuery($cn, $tableId, $viewId, $filter->create(), $sqlBuilder->QUERY_NO_JOIN);
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
            }

            // Close connection
            if ($cn) {
                pg_close($cn); 
            }    

            // Return results
            if ($sqlBuilder->getError() != "") {
                $output = $sqlBuilder->getError();
            } else {
                $output = $sqlBuilder->getMessage();        
            }
            
            // Return final results
            return $output;
        }



    } // End of class
?>