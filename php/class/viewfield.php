<?php
    class LogicViewField extends Base {

        // Private members
        private $cn = 0;

        // Constructor
        function __construct($cn) {
            $this->cn = $cn;
        }

        /*
         * Logic before persist record
         */
        public function before($old, $new) {

            // General declaration
            try {

                // Delete it
                switch ($this->getAction()) {
                    case "New":
                    case "Update":
                        $this->validateViewField($new);
                        break;
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

        /*
         * Private members
         */
        public function validateViewField($new) {

            $rs = "";
            $sql = "";
            $data = array();
            $command = 0;
            $tableId = 0;
            $fieldId = 0;
            $fieldType = "";
            $error = "";
            $jsonUtil = new JsonUtil();
            $message = new Message($this->cn);
            $sqlBuilder = new SqlBuilder();

            try {

                // Figure out the command
                $command = $jsonUtil->getValue($new, "id_command");

                // Get field ID
                $tableId = $jsonUtil->getValue($new, "id_table");
                $fieldId = $jsonUtil->getValue($new, "id_field");

                // Figure out field type
                $filter = new Filter();
                $filter->add("tb_field", "id_table", $tableId);
                $filter->add("tb_field", "id", $fieldId);
                $data = $sqlBuilder->executeQuery($this->cn, 
                                                  $this->TB_FIELD, 0,
                                                  $filter->create(), 
                                                  $sqlBuilder->QUERY_NO_PAGING);

                if (count($data) > 0) {
                    $fieldType = $data[0]["id_type"];
                }                                                            

                // Validate it
                switch ($command) {
                    case $this->SUM:
                    case $this->MAX:
                    case $this->MIN:
                        // Valid data types
                        if ($fieldType != $this->TYPE_INT && 
                            $fieldType != $this->TYPE_FLOAT && 
                            $fieldType != $this->TYPE_DATE) {
                                $error = "M21";
                        }
                        break;

                    case $this->AVG:
                        // Valid data types
                        if ($fieldType != $this->TYPE_INT && 
                            $fieldType != $this->TYPE_FLOAT) {
                                $error = "M22";
                        }
                }

                // Validate it
                if ($error != "") {

                    // Get error message
                    $error = $message->getValue($error);

                    // Keep it
                    $this->setError("LogicViewField.validateViewField()", $error);

                    // Throw it
                    throw new Exception($error);
                }

            } catch (Exception $ex) {
                throw $ex;
            }
        }



    } // End of class
?>