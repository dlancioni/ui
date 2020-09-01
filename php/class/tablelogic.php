<?php
    class TableLogic extends Base {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;
        private $tableDef = "";
        private $tableData = "";

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
        }

        /*
         * Logic before persist record
         */
        public function before($old, $new) {

            try {

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }

        /*
         * Logic before persist record
         */
        public function after($id, $old, $new) {

            try {

                // Create, rename or delete table
                $this->handleTable($old, $new);

                // Create or delete events
                $this->handleEvent($id);

                // Delete fields
                $this->handleField($id);                

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }

        /*
         * Create physical table for current transaction
         */
        private function handleTable($old, $new) {

            // General Declaration
            $sql = "";
            $json = "";
            $tableOld = "";
            $tableNew = "";

            try {

                // Figure out table name   
                if ($old != "{}") {
                    $json = json_decode($old);
                    $tableOld = $json->{'table_name'};
                }

                if ($new != "{}") {
                    $json = json_decode($new);
                    $tableNew = $json->{'table_name'};
                }

                // Take action on tables according to current event
                if (trim($json->{'id_type'}) != "3") {

                    switch ($this->sqlBuilder->getEvent()) {
                        
                        // Create it
                        case "New":                        
                            $sql = "drop table if exists " . $tableNew;
                            pg_query($this->cn, $sql);
                            $sql = "create table if not exists " . $tableNew . " (id serial, field jsonb);";
                            pg_query($this->cn, $sql);
                            break;
    
                        // Rename it
                        case "Edit":
                            if ($tableOld != $tableNew) {
                                $sql = "alter table " . $tableOld . " rename to " . $tableNew;
                                pg_query($this->cn, $sql);                        
                            }
                            break;
    
                        // Delete it                            
                        case "Delete":
                            $sql = "drop table if exists " . $tableOld;
                            pg_query($this->cn, $sql);
                            break;                        
                    }                    
                }

            } catch (Exception $ex) {

                // Keep source and error
                $this->sqlBuilder->setError("TableLogic.handleTable()", $ex->getMessage());

                // Rethrow it
                throw $ex;

            } finally {
                // Do nothing
            }
        }

        /*
         * Create crud buttons for new table
         */
        private function handleEvent($tableId) {

            // General Declaration
            $rs = "";
            $json = "";            
            $sql = "";
            $html = "";
            $EVENT = 5;
            $TB_SYSTEM = 1;
            $tableDef = "";
            $fieldName = "";
            $fieldValue = "";            
            $affectedRows = "";
            $jsonUtil = new JsonUtil();

            try {

                // Delete related events
                if ($this->sqlBuilder->getEvent() == "Delete") {
                    
                    $sql .= " delete from tb_event";
                    $sql .= " where " . $jsonUtil->condition("tb_event", "id_system", "int", "=", $this->sqlBuilder->getSystem());
                    $sql .= " and " . $jsonUtil->condition("tb_event", "id_table", "int", "=", $tableId);
                    $rs = pg_query($this->cn, $sql);
                    $affectedRows = pg_affected_rows($rs);

                // Copy events from TB_SYSTEM
                } elseif ($this->sqlBuilder->getEvent() == "New") {

                    $filter = new Filter();
                    $filter->addCondition("tb_event", "id_table", "int", "=", $TB_SYSTEM);
                    $filter->addCondition("tb_event", "id_action", "int", "<>", "0");
                    $tableData = $this->sqlBuilder->Query($this->cn, $EVENT, $filter->create());
                    $tableDef = $this->sqlBuilder->getTableDef($this->cn);

                    // Create main menu
                    foreach ($tableData as $row) {
                        foreach ($tableDef as $col) {

                            // Get keys
                            $fieldName = $col["field_name"];
                            $fieldValue = $row[$fieldName];

                            // Set new table target
                            if ($fieldName == "id_table") {
                                $fieldValue = $tableId;
                            }
                            $json = $jsonUtil->setValue($json, $fieldName, $fieldValue);
                        }

                        $id = $this->sqlBuilder->persist($this->cn, "tb_event", $json);
                        $json = "";
                    }                    
                }

            } catch (Exception $ex) {

                // Keep source and error                
                $this->sqlBuilder->setError("TableLogic.handleEvent()", $ex->getMessage());

                // Rethrow it
                throw $ex;

            } finally {
                // do nothing
            }
        }       


        /*
         * Delete fields
         */
        private function handleField($tableId) {

            // General Declaration
            $sql = "";
            $rs = "";
            $jsonUtil = new JsonUtil();
            $affectedRows = 0;

            try {

                // Delete related events
                if ($this->sqlBuilder->getEvent() == "Delete") {
                    $sql .= " delete from tb_field";
                    $sql .= " where " . $jsonUtil->condition("tb_field", "id_system", "int", "=", $this->sqlBuilder->getSystem());
                    $sql .= " and " . $jsonUtil->condition("tb_field", "id_table", "int", "=", $tableId);
                    $rs = pg_query($this->cn, $sql);
                    $affectedRows = pg_affected_rows($rs);
                }    

            } catch (Exception $ex) {

                // Keep source and error                
                $this->sqlBuilder->setError("TableLogic.handleField()", $ex->getMessage());

                // Rethrow it
                throw $ex;

            } finally {
                // Do nothing
            }
        }        

    } // End of class
?>