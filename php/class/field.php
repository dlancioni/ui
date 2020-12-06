<?php
    class LogicField extends Base {

        // Private members
        private $cn = 0;
        private $tableDef = "";
        private $tableData = "";

        // Constructor
        function __construct($cn) {
            $this->cn = $cn;
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
            $message = new Message($this->cn);

            try {

                // Validate date fields missing mask
                if ($jsonUtil->getValue($new, "id_type") == $this->TYPE_DATE) {
                    if (trim($jsonUtil->getValue($new, "mask")) == "") {
                        $msg = $message->getValue("A10");
                        $msg = str_replace("%", $jsonUtil->getValue($new, "label"), $msg);
                        throw new Exception($msg);
                    }
                }

                // Validate TableFK without field - it causes system crash
                if ($this->getTable() == $this->TB_FIELD) {
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

            try {

            } catch (Exception $ex) {
                throw $ex;
            }
        }

    } // End of class
?>