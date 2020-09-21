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

                // Validate transaction where field is been added
                switch ($this->sqlBuilder->getEvent()) {
                    case "New":
                    case "Edit":
                        $filter = new Filter();
                        $filter->addCondition("tb_table", "id", "int", "=", $jsonUtil->getValue($new, "id_table"));
                        $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_TABLE, $filter->create());
                        if ($data) {
                            if ($data[0]["id_type"] == 3) {
                                $msg = $message->getValue("A10");
                                throw new Exception($msg);
                            }
                        }
                        break;                        
                }

                // Validate TableFK without field - it causes system crash
                if ($jsonUtil->getValue($new, "id_table_fk") != "0") {
                    if ($jsonUtil->getValue($new, "id_field_fk") == "0") {
                        $msg = $message->getValue("A9");
                        throw new Exception($msg);
                    }
                }

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


            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }


    } // End of class
?>