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
            $message = "";
            $jsonUtil = new JsonUtil();
            $message = new Message($this->cn, $this->sqlBuilder);

            try {

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