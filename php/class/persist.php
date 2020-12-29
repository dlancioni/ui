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
            $message = "";
            $tableDef = "";
            $tableName = "";
            $jsonUtil = "";
            $unique = "";    
            $output = "";
            $event = "";
            $fieldName = "";       
            $fieldType = "";
            $sqlBuilder = "";    
            $fieldUnique = "";
            $fieldLabel = "";    
            $changed = false;
            $file = "";
            $systemId = "";
            $moduleId = 0;
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
                if (isset($session["_MODULE_"])) {
                    $this->setModule($session["_MODULE_"]);
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
                if (isset($session["_EVENT_"])) {
                    $this->setEvent($session["_EVENT_"]);
                }

                // Validate properties above
                // Pending yet

                // To simplify and debug, keep in variables
                $systemId = $this->getSystem();
                $moduleId = $this->getModule();
                $userId = $this->getUser();
                $groupId = $this->getGroup();
                $event = $this->getEvent();

                // Open connection
                $db = new Db();
                $cn = $db->getConnection($systemId);

                // Object instances
                $logUtil = new LogUtil();
                $jsonUtil = new JsonUtil();
                $stringUtil = new StringUtil();
                $numberUtil = new NumberUtil();
                $message = new Message($cn);
                $sqlBuilder = new SqlBuilder($systemId, $moduleId, $userId, $groupId);

                // Keep important objects
                $this->cn = $cn;
                $this->sqlBuilder = $sqlBuilder;

                // Get module structure
                $tableDef = $sqlBuilder->getTableDef($cn, $moduleId, $viewId);
                $logUtil->log("table_def.pgsql", $sqlBuilder->lastQuery);
                if ($tableDef) {
                    $tableName = $tableDef[0]["table_name"];
                }

                // Check fks before delete
                if ($event == $this->ACTION_DELETE) {
                    $this->validateFkOnDelete($moduleId, $this->getLastId());
                }

                // Rules for update/delete
                if ($event == $this->ACTION_EDIT || $event == $this->ACTION_DELETE) {

                    // Get existing record
                    $filter = new Filter();
                    $filter->add($tableName, "id", $this->getLastId());
                    $data = $sqlBuilder->executeQuery($cn, $moduleId, $viewId, $filter->create(), $sqlBuilder->QUERY_NO_JOIN);
                    if (count($data) > 0) {
                        $old = json_encode($data[0]);
                        $old = $stringUtil->RemoveSpecialChar($old);
                        $new = $old;
                    }

                    // Cannot touch system info
                    if ($sqlBuilder->getGroup() > 1) {
                        if ($jsonUtil->getValue($old, "id_group", true) == "1") {
                            $msg = $message->getValue("M11", $key);
                            throw new Exception($msg);
                        }
                    }
                }

                // Upload files on insert only
                if ($event == $this->ACTION_NEW || $event == $this->ACTION_EDIT) {
                    if (count($_FILES) > 0) {
                        $logicUpload = new LogicUpload($cn);
                        $logicUpload->uploadFiles($_FILES, $systemId, $groupId);
                    }
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
                if ($event == $this->ACTION_NEW || $event == $this->ACTION_EDIT) {
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
                        $msg = $message->getValue("M5");
                        throw new Exception($msg);
                    }

                    // Check if values already exists
                    if ($filter->create() != "[]") {
                        $data = $sqlBuilder->executeQuery($cn, $moduleId, $viewId, $filter->create(), $sqlBuilder->QUERY_NO_JOIN);
                        if (count($data) > 0) {
                            $key =  rtrim($key, ", ");
                            $msg = $message->getValue("M4", $key);
                            throw new Exception($msg);
                        }
                    }
                }

                // Open transaction
                pg_query($cn, "begin");

                    // Persist info
                    $id = $this->persist($cn, $tableName, $old, $new);

                // Open transaction
                pg_query($cn, "commit");

                // Set final id
                $sqlBuilder->setLastId($id);

            } catch (Exception $ex) {

                // Keep the error
                $this->setError("Persist()", $ex->getMessage());

                // Open transaction
                pg_query($cn, "rollback");
            }

            // Close connection
            if ($cn) {
                pg_close($cn); 
            }    

            // Return results
            if ($this->getError() != "") {
                $output = $this->getError();
            } else {
                $output = $this->getMessage();        
            }
            
            // Return final results
            return $output;
        }

       /* 
        * Persist data
        */
        public function persist($cn, $tableName, $old, $new) {
            
            // General declaration
            $id = 0;
            $rs = "";            
            $sql = "";
            $msg = "";
            $logic = "";
            $message = "";
            $affectedRows = "";
            $jsonUtil = new jsonUtil();
            $message = new Message($cn);

            // Make sure id_group is set
            $new = $jsonUtil->setValue($new, "id_group", $this->getGroup());

            // Get logic for current transaction
            switch ($tableName) {
                case "tb_module":
                    $logic = new LogicModule($cn);
                    break;                
                case "tb_field":
                    $logic = new LogicField($cn);
                    break;
                case "tb_event":
                    $logic = new LogicEvent($cn);
                    break;
                case "tb_view":
                    $logic = new LogicView($cn);
                    break;
                case "tb_view_field":
                    $logic = new LogicViewField($cn);
                    break;                    
                default:  
                    $logic  = "";
            }

            // Before insert logic 
            if ($logic) {

                // Set important keys
                $logic->setEvent($this->getEvent());
                $logic->setGroup($this->getGroup());

                // Trigger before
                $logic->before($old, $new);
            }

            // Prepare sql string according to the event
            try {

                switch ($this->getEvent()) {
                    case $this->ACTION_NEW:
                        $msg = "M6";                        
                        $sql = "insert into $tableName (field) values ('$new') returning id";                        
                        break;
                    case $this->ACTION_EDIT:
                        $msg = "M7";                        
                        $sql .= " update $tableName set field = '$new' ";
                        $sql .= " where " . $jsonUtil->condition($tableName, "id", $this->TYPE_INT, "=", $this->getLastId());
                        break;
                    case $this->ACTION_DELETE:
                        $msg = "M8";                        
                        $sql .= " delete from $tableName ";
                        $sql .= " where " . $jsonUtil->condition($tableName, "id", $this->TYPE_INT, "=", $this->getLastId());                        
                        break;
                }

                // Execute statement            
                $rs = pg_query($cn, $sql);
                if (!$rs) {
                    throw new Exception(pg_last_error($cn));
                }

                // Get inserted ID
                $affectedRows = pg_affected_rows($rs);                
                while ($row = pg_fetch_array($rs)) {
                    $this->setLastId($row['id']);
                    $id = $this->getLastId();
                }

                // After insert logic
                if ($logic) {
                    $logic->after($id, $old, $new);
                }

                // Get final message
                $msg = $message->getValue($msg);

                // Success
                $this->setError("", "");
                $this->setMessage($msg);

            } catch (Exception $ex) {

                // Keep last error
                $this->setMessage("");
                $this->setError("Persist.persist()", $ex->getMessage());

                // Very important to handle transaction
                throw $ex;
            }
            
            // Return ID
            return $this->getLastId();
        }

       /* 
        * Use for setup only
        */
        public function add($cn, $tableName, $record) {
            try {
                $this->persist($cn, $tableName, "", $record);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Validate fk on delete
         */
        private function validateFkOnDelete($moduleId, $id) {

            // General declaration
            $viewId = 0;
            $error = "";
            $filter = "";
            $tableName = "";
            $fieldName = "";
            $title = "";
            $message = "";
            $data = array();
            $modules = array();

            try {

                // Get parent modules
                $filter = new Filter();
                $filter->add("tb_field", "id_module_fk", $moduleId);
                $modules = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_FIELD, $viewId, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);

                // Check if ID exists in parent modules
                foreach ($modules as $module) {

                    // Keep key field name
                    $fieldName = $module["name"];

                    // Figure out table name for fk
                    $filter = new Filter();
                    $filter->add("tb_module", "id", $module["id_module"]);
                    $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_MODULE, $viewId, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                    if (count($data) > 0) {
                        $tableName = $data[0]["name"];
                        $title = $data[0]["title"];
                    }

                    // Check for data
                    $filter = new Filter();
                    $filter->add($tableName, $fieldName, $id);
                    $data = $this->sqlBuilder->executeQuery($this->cn, $module["id_module"], $viewId, $filter->create());
                    if (count($data) > 0) {
                        $message = new Message($this->cn);
                        $error = $message->getValue("M30", $title);
                        throw new Exception($error);
                    }
                }
            } catch (Exception $ex) {
                throw $ex;
            }
        }


    } // End of class
?>