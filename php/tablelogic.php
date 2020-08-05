<?php
    class TableLogic extends Base {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;
        private $tableDef = "";
        private $tableData = "";

        // Constructor
        function __construct($cn, $sqlBuilder, $db) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
            $this->db = $db;
        }

        /*
         * Logic before persist record
         */
        public function before($record) {

            try {

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Logic before persist record
         */
        public function after($tableId, $record) {

            try {

                // Create, rename or delete table
                $this->handleTable($record);

                // Create or delete events
                $this->handleEvent($tableId);

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create physical table for current transaction
         */
        private function handleTable($record) {

            // General Declaration
            $sql = "";
            $json = "";
            $tableName = "";            

            try {

                // Figure out table name   
                $json = json_decode($record);
                $tableName = $json->{'name'};

                // Take action on tables according to current event
                switch ($this->db->getEvent()) {

                    // Create it
                    case "New":                        
                        $sql = "drop table if exists " . $tableName;
                        pg_query($this->cn, $sql);
                        $sql = "create table if not exists " . $tableName . " (id serial, field jsonb);";
                        pg_query($this->cn, $sql);
                        break;

                    // Rename it
                    case "Edit":
                        break;

                    // Delete it                            
                    case "Delete":
                        // Create statement
                        $sql = "drop table if exists " . $tableName;
                        pg_query($this->cn, $sql);
                        break;                        
                }

            } catch (Exception $ex) {
                $this->db->setError("TableLogic.createTable()", $ex->getMessage());
                throw $ex;
            }
        }

        /*
         * Create crud buttons for new table
         */
        private function handleEvent($tableId) {

            // General Declaration
            $json = "";            
            $sql = "";
            $html = "";
            $EVENT = 5;
            $TABLE = 2;
            $tableDef = "";
            $fieldName = "";
            $fieldValue = "";
            $tableName = "tb_event";
            $db = new Db();
            $jsonUtil = new JsonUtil();            

            try {

                // Delete related events
                if ($this->db->getEvent() == "Delete") {

                    

                    $sql .= " delete from $tableName";
                    $sql .= " where " . $jsonUtil->condition($tableName, "id_system", "int", "=", $this->db->getSystem());
                    $sql .= " and " . $jsonUtil->condition($tableName, "id_table", "int", "=", $tableId);
                    pg_query($this->cn, $sql);

                // Copy events from TB_SYSTEM
                } elseif ($this->db->getEvent() == "New") {

                    $filter = new Filter();
                    $filter->add("tb_event", "id_table", $TABLE);
                    $tableData = $this->sqlBuilder->Query($this->cn, $EVENT, $filter->create());
                    $tableDef = $this->sqlBuilder->getTableDef($this->cn, "json");

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

                        $id = $this->db->persist($this->cn, "tb_event", $json);
                        $json = "";
                    }                    
                }

            } catch (Exception $ex) {
                $this->db->setError("TableLogic.createEvent()", $ex->getMessage());
                throw $ex;
            }
        }       

    } // End of class
?>