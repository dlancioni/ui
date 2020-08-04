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
         * Orchestrate new table logic
         */
        public function afterInsert($tableId, $record) {

            // General Declaration
            $obj = "";
            $tableName = "";

            try {

                // Create physical table
                $this->createTable($record);

                // Create events using tb_table as template (new, edit, confirm, etc)
                $this->createEvent($tableId);

            } catch (Exception $ex) {
                throw $ex;
            }
        }        


        /*
         * Create physical table for current transaction
         */
        private function createTable($record) {

            // General Declaration
            $obj = "";
            $tableName = "";

            try {

                // Figure out table name
                $obj = json_decode($record);
                $tableName = $obj->{'name'};

                // Create it
                pg_query($this->cn, "drop table if exists " . $tableName);
                pg_query($this->cn, "create table if not exists " . $tableName . " (id serial, field jsonb);");

            } catch (Exception $ex) {
                throw $ex;
            }
        }        

        /*
         * Create crud buttons for new table
         */
        private function createEvent($tableId) {

            // General Declaration            
            $html = "";
            $EVENT = 5;
            $TABLE = 2;
            $db = new Db();
            $jsonUtil = new JsonUtil();
            $tableDef = "";
            $json = "";
            $fieldName = "";
            $fieldValue = "";

            try {

                // Get data
                $filter = new Filter();
                $filter->add("tb_event", "id_table", $TABLE);
                $tableData = $this->sqlBuilder->Query($this->cn, $EVENT, $filter->create());

                // Get table def
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

            } catch (Exception $ex) {
                throw $ex;
            }
        }

    } // End of class
?>