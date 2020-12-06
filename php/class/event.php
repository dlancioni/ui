<?php
    class LogicEvent extends Base {

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
                $this->tableAction($old, $new);

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }


        /*
         * Once new action is created, need to grant access
         */
        private function tableAction($old, $new) {

            // General Declaration
            $id = 0;            
            $sql = "";
            $rs = "";
            $json = "";
            $record = "";
            $tableId = 0;
            $viewId = 0;
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $model = new Model($this->getGroup());

            try {

                // Grant profiles Admin and User
                switch ($this->getAction()) {

                    case "New":

                        // Get keys
                        $tableId = $jsonUtil->getValue($new, "id_table");
                        $id = $jsonUtil->getValue($new, "id_action");

                        // When event is a FUNCTION, grant permission to admin
                        if (intval($id) != 0) {

                            // System
                            $json = $model->addTableAction($this->PROFILE_SYSTEM, $tableId, $id);
                            pg_query($this->cn, "insert into tb_table_action (field) values ('$json')");

                            // Administrator
                            $json = $model->addTableAction($this->PROFILE_ADMIN, $tableId, $id);
                            pg_query($this->cn, "insert into tb_table_action (field) values ('$json')");

                            // Users
                            $json = $model->addTableAction($this->PROFILE_USER, $tableId, $id);
                            pg_query($this->cn, "insert into tb_table_action (field) values ('$json')");

                            break;
                        }

                    case "Delete":

                        // Get keys
                        $tableId = $jsonUtil->getValue($old, "id_table");
                        $id = $jsonUtil->getValue($old, "id_action");

                        // When event is a FUNCTION, revoke permission from admin
                        if (intval($id) != 0) {                           
                            $sql = "";
                            $sql .= " delete from tb_table_action";
                            $sql .= " where " . $jsonUtil->condition("tb_table_action", "id_table", $this->TYPE_INT, "=", $tableId);
                            $sql .= " and " . $jsonUtil->condition("tb_table_action", "id_action", $this->TYPE_INT, "=", $id);
                            $rs = pg_query($this->cn, $sql);
                            $affectedRows = pg_affected_rows($rs);
                        }
                }

            } catch (Exception $ex) {

                // Keep source and error                
                $this->setError("TableLogic.profileTransaction()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }        

    } // End of class
?>