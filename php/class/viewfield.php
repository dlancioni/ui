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
            $operator = "";
            $value = "";
            $jsonUtil = new JsonUtil();
            $message = new Message($this->cn);
            $sqlBuilder = new SqlBuilder();

            try {

                // Get data
                $tableId = $jsonUtil->getValue($new, "id_table");
                $fieldId = $jsonUtil->getValue($new, "id_field");                
                $command = $jsonUtil->getValue($new, "id_command");
                $operator = $jsonUtil->getValue($new, "id_operator");
                $value = $jsonUtil->getValue($new, "value");

                // Validate key fields
                if ($tableId == 0) {
                    $error = $message->getValue("M1");
                    $error = str_replace("%", "Tabela", $error);
                }

                if ($fieldId == 0) {
                    $error = $message->getValue("M1");
                    $error = str_replace("%", "Campo", $error);
                }                

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

                    // Valid data types
                    case $this->SUM:
                    case $this->MAX:
                    case $this->MIN:
                        if ($fieldType != $this->TYPE_INT && 
                            $fieldType != $this->TYPE_FLOAT && 
                            $fieldType != $this->TYPE_DATE) {
                                $error = $message->getValue("M21");
                        }
                        break;

                    // Valid data types                        
                    case $this->AVG:
                        if ($fieldType != $this->TYPE_INT && 
                            $fieldType != $this->TYPE_FLOAT) {
                                $error = $message->getValue("M22");
                        }

                    // Validate selection
                    case $this->SELECTION:
                        if ($operator != 0 || trim($value) != "") {
                            $error = $message->getValue("M23");
                        }
                        break;

                    // Validate condition
                    case $this->CONDITION:
                        if ($operator == 0 || trim($value) == "") {
                            $error = $message->getValue("M24");
                        }
                        break;
                }

                // Validate it
                if ($error != "") {

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