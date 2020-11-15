<?php
    class LogicTable extends Base {

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
         * Transactional logic BEFORE insert
         */
        public function before($old, $new) {

            try {

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }

        /*
         * Transactional logic AFTER insert
         */
        public function after($id, $old, $new) {

            try {

                // Create, rename or delete table
                $this->table($old, $new);

                // Delete fields
                $this->field($id);

                // Profile x Transaction
                $this->profileTransaction($id);

                // Transaction x Function
                $this->transactionFunction($id);

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }

        /*
         * Create physical table for current transaction
         */
        private function table($old, $new) {

            // General Declaration
            $sql = "";
            $json = "";
            $tableOld = "";
            $tableNew = "";

            try {

                // Figure out table name   
                if ($old != "{}") {
                    $json = json_decode($old);
                    $tableOld = $json->{'name'};
                }

                if ($new != "{}") {
                    $json = json_decode($new);
                    $tableNew = $json->{'name'};
                }

                // Take action on tables according to current event
                if (trim($json->{'id_type'}) != "3") {

                    switch ($this->sqlBuilder->getAction()) {
                        
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
                $this->sqlBuilder->setError("TableLogic.table()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }

        /*
         * Delete fields
         */
        private function field($tableId) {

            // General Declaration
            $sql = "";
            $rs = "";
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();            

            try {

                // Delete related events
                if ($this->sqlBuilder->getAction() == "Delete") {
                    $sql .= " delete from tb_field";
                    $sql .= " where " . $jsonUtil->condition("tb_field", "id_system", $this->TYPE_TEXT, "=", $this->sqlBuilder->getSystem());
                    $sql .= " and " . $jsonUtil->condition("tb_field", "id_table", $this->TYPE_INT, "=", $tableId);
                    $rs = pg_query($this->cn, $sql);
                    $affectedRows = pg_affected_rows($rs);
                }    

            } catch (Exception $ex) {

                // Keep source and error                
                $this->sqlBuilder->setError("TableLogic.field()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }


        /*
         * Delete fields
         */
        private function profileTransaction($tableId) {

            // General Declaration
            $sql = "";
            $rs = "";
            $json = "";
            $record = "";
            $affectedRows = 0;
            $tableDef = "";
            $jsonUtil = new JsonUtil();

            try {

                // Get structure to generate json
                $tableDef = $this->sqlBuilder->getTableDef($this->cn, $this->sqlBuilder->TB_PROFILE_TABLE);
                $json = $jsonUtil->getJson($tableDef);

                // Grant for system, admin and user
                switch ($this->sqlBuilder->getAction()) {

                    case "New":
                        for ($i=1; $i<=3; $i++) {
                            $json = $jsonUtil->setValue($json, "id_profile", $i);
                            $json = $jsonUtil->setValue($json, "id_table", $tableId);
                            $id = $this->sqlBuilder->persist($this->cn, "tb_profile_table", $json);
                        }

                        // Finish insert flow
                        break;

                    case "Delete":
                        // Remove transaction from Profile x Transaction
                        $sql = "";
                        $sql .= " delete from tb_profile_table";
                        $sql .= " where " . $jsonUtil->condition("tb_profile_table", "id_system", $this->TYPE_TEXT, "=", $this->sqlBuilder->getSystem());
                        $sql .= " and " . $jsonUtil->condition("tb_profile_table", "id_table", $this->TYPE_INT, "=", $tableId);
                        $rs = pg_query($this->cn, $sql);
                        $affectedRows = pg_affected_rows($rs);
                        break;                    
                }

            } catch (Exception $ex) {

                // Keep source and error                
                $this->sqlBuilder->setError("TableLogic.profileTransaction()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }

        private function transactionFunction($tableId) {

            // General Declaration
            $sql = "";
            $rs = "";
            $json = "";
            $record = "";
            $affectedRows = 0;
            $tableDef = "";
            $jsonUtil = new JsonUtil();

            try {

                // Get structure to generate json
                $tableDef = $this->sqlBuilder->getTableDef($this->cn, $this->sqlBuilder->TB_TABLE_FUNCTION);
                $json = $jsonUtil->getJson($tableDef);

                // Grant profiles Admin and User
                switch ($this->sqlBuilder->getAction()) {

                    case "New":
                        // Add standard 7 functions (New, Edit, Delete, Confirm, Filter, Clear, Back)
                        for ($i=1; $i<=3; $i++) {
                            for ($j=1; $j<=7; $j++) {
                                $json = $jsonUtil->setValue($json, "id_profile", $i);
                                $json = $jsonUtil->setValue($json, "id_table", $tableId);
                                $json = $jsonUtil->setValue($json, "id_function", $j);
                                $id = $this->sqlBuilder->persist($this->cn, "tb_table_function", $json);
                            }
                        }
                        // Finish insert flow
                        break;

                    case "Delete":
                        // Remove transaction from Transaction x Function
                        $sql = "";
                        $sql .= " delete from tb_table_function";
                        $sql .= " where " . $jsonUtil->condition("tb_table_function", "id_system", $this->TYPE_TEXT, "=", $this->sqlBuilder->getSystem());
                        $sql .= " and " . $jsonUtil->condition("tb_table_function", "id_table", $this->TYPE_INT, "=", $tableId);
                        $rs = pg_query($this->cn, $sql);
                        $affectedRows = pg_affected_rows($rs);
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