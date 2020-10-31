<?php
    class LogicEvent extends Base {

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

                // Set permission for admin
                $this->transactionFunction($old, $new);

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }


        private function transactionFunction($old, $new) {

            // General Declaration
            $id = 0;            
            $sql = "";
            $rs = "";
            $json = "";
            $record = "";
            $tableId = 0;
            $affectedRows = 0;
            $tableDef = "";
            $jsonUtil = new JsonUtil();

            try {

                // Get structure to generate json
                $tableDef = $this->sqlBuilder->getTableDef($this->cn, $this->sqlBuilder->TB_TRANSACTION_FUNCTION);
                $json = $jsonUtil->getJson($tableDef);

                // Grant profiles Admin and User
                switch ($this->sqlBuilder->getEvent()) {

                    case "New":

                        // Get keys
                        $tableId = $jsonUtil->getValue($new, "id_table");
                        $id = $jsonUtil->getValue($new, "id_function");

                        // When event is a FUNCTION, grant permission to admin
                        if (intval($id) != 0) {
                            $json = $jsonUtil->setValue($json, "id_profile", 1);
                            $json = $jsonUtil->setValue($json, "id_table", $tableId);
                            $json = $jsonUtil->setValue($json, "id_function", $id);
                            $id = $this->sqlBuilder->persist($this->cn, "tb_table_function", $json);
                            break;
                        }

                    case "Delete":

                        // Get keys
                        $tableId = $jsonUtil->getValue($old, "id_table");
                        $id = $jsonUtil->getValue($old, "id_function");

                        // When event is a FUNCTION, revoke permission from admin
                        if (intval($id) != 0) {
                            $sql = "";
                            $sql .= " delete from tb_table_function";
                            $sql .= " where " . $jsonUtil->condition("tb_table_function", "id_system", "text", "=", $this->sqlBuilder->getSystem());
                            $sql .= " and " . $jsonUtil->condition("tb_table_function", "id_table", "int", "=", $tableId);
                            $sql .= " and " . $jsonUtil->condition("tb_table_function", "id_function", "int", "=", $id);
                            $rs = pg_query($this->cn, $sql);
                            $affectedRows = pg_affected_rows($rs);
                        }
                }

            } catch (Exception $ex) {

                // Keep source and error                
                $this->sqlBuilder->setError("TableLogic.profileTransaction()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }        

    } // End of class
?>