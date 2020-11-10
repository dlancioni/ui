<?php
    class LogicField extends Base {

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

            // General declaration
            $msg = "";
            $data = "";
            $message = "";
            $jsonUtil = new JsonUtil();
            $message = new Message($this->cn, $this->sqlBuilder);

            try {

                // Validate TableFK without field - it causes system crash
                if ($this->sqlBuilder->getTable() == $this->sqlBuilder->TB_FIELD) {
                    if ($jsonUtil->getValue($new, "id_table_fk") != "0") {
                        if ($jsonUtil->getValue($new, "id_field_fk") == "0") {
                            $msg = $message->getValue("A9");
                            throw new Exception($msg);
                        }
                    }
                }

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Logic before persist record
         */
        public function after($id, $old, $new) {

            $tableId = 0;
            $tableName = "";
            $fieldName = "";
            $fieldNameOld = "";
            $jsonUtil = new JsonUtil();

            try {

                // Keep field atributes
                $tableId = $jsonUtil->getValue($new, "id_table");
                $tableName = $this->getTableName($tableId);
                $fieldName = $jsonUtil->getValue($new, "name");

                // Binary info cannot be stored in json, need dedicated column
                if ($jsonUtil->getValue($new, "id_type") == $this->TYPE_BINARY) {

                    // Affect table according to the event
                    switch ($this->sqlBuilder->getAction()) {

                        case "New":
                            $sql = "alter table $tableName add $fieldName bytea";
                            pg_query($this->cn, $sql);
                            break;
                        case "Edit":
                            $fieldNameOld = $jsonUtil->getValue($old, "name");
                            $sql = "alter table $tableName rename column $fieldNameOld to $fieldName";
                            pg_query($this->cn, $sql);
                            break;
                        case "Delete":
                            $sql = "alter table $tableName drop column if exists $fieldName";
                            pg_query($this->cn, $sql);
                            break;
                    }
                }

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        private function getTableName($tableId) {

            $tableName = "";
            $filter = new Filter();
            $filter->add("tb_table", "id", $tableId);
            $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_TABLE, $filter->create());
            foreach ($data as $item) {
                $tableName = $data[0]["name"];
                break;
            }
            return $tableName;                
        }


    } // End of class
?>