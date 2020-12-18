<?php
    class LogicModule extends Base {

        // Private members
        private $cn = 0;
        private $tableDef = "";
        private $tableData = "";

        // Constructor
        function __construct($cn) {
            $this->cn = $cn;
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

                // Action and events
                $this->actionEvent($id);

                // Delete fields
                $this->field($id);

                // Profile x Transaction
                $this->profileTransaction($id);

                // Transaction x Function
                $this->tableAction($id);

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
                if (trim($old) != "") {
                    if ($old != "{}") {
                        $json = json_decode($old);
                        $tableOld = $json->{'name'};
                    }
                }

                if (trim($new) != "") {                
                    if ($new != "{}") {
                        $json = json_decode($new);
                        $tableNew = $json->{'name'};
                    }
                }

                // Take action on tables according to current event
                switch ($this->getAction()) {
                    
                    // Create it
                    case $this->ACTION_NEW:
                        $sql = "drop table if exists " . $tableNew;
                        pg_query($this->cn, $sql);
                        $sql = "create table if not exists " . $tableNew . " (id serial, field jsonb);";
                        pg_query($this->cn, $sql);
                        break;

                    // Rename it
                    case $this->ACTION_EDIT:
                        if ($tableOld != $tableNew) {
                            $sql = "alter table " . $tableOld . " rename to " . $tableNew;
                            pg_query($this->cn, $sql);                        
                        }
                        break;

                    // Delete it                            
                    case $this->ACTION_DELETE:
                        $sql = "drop table if exists " . $tableOld;
                        pg_query($this->cn, $sql);
                        break;                        
                }

            } catch (Exception $ex) {

                // Keep source and error
                $this->setError("TableLogic.table()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }

        /*
         * Create standard actions 
         */        
        private function actionEvent($moduleId) {

            // General Declaration
            $sql = "";
            $rs = "";
            $json = "";
            $record = "";
            $affectedRows = 0;
            $tableDef = "";
            $viewId = 0;
            $jsonUtil = new JsonUtil();
            $model = new Model($this->getGroup());

            $TABLE = 1;
            $FORM = 2;

            $EVENT_ONCLICK = 2;

            try {

                // Grant profiles Admin and User
                switch ($this->getAction()) {

                    case $this->ACTION_NEW:
                        
                        // New
                        $json = $model->addEvent($TABLE, $moduleId, 0, 1, $EVENT_ONCLICK, 'formNew();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Edit
                        $json = $model->addEvent($TABLE, $moduleId, 0, 2, $EVENT_ONCLICK, 'formEdit();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Delete
                        $json = $model->addEvent($TABLE, $moduleId, 0, 3, $EVENT_ONCLICK, 'formDelete();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Confirm
                        $json = $model->addEvent($FORM, $moduleId, 0, 4, $EVENT_ONCLICK, 'confirm();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Filter
                        $json = $model->addEvent($TABLE, $moduleId, 0, 5, $EVENT_ONCLICK, 'formFilter();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Clear
                        $json = $model->addEvent($FORM, $moduleId, 0, 6, $EVENT_ONCLICK, 'formClear();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Back
                        $json = $model->addEvent($FORM, $moduleId, 0, 7, $EVENT_ONCLICK, 'reportBack();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        break;

                    case $this->ACTION_DELETE:
                        // Remove transaction from Transaction x Function
                        $sql = "";
                        $sql .= " delete from tb_event";
                        $sql .= " where " . $jsonUtil->condition("tb_event", "id_module", $this->TYPE_INT, "=", $moduleId);
                        $rs = pg_query($this->cn, $sql);
                        $affectedRows = pg_affected_rows($rs);
                }

            } catch (Exception $ex) {

                // Keep source and error                
                $this->setError("TableLogic.actionEvent()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }        

        /*
         * Handle fields (delete only)
         */
        private function field($moduleId) {

            // General Declaration
            $sql = "";
            $rs = "";
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();            

            try {

                // Delete related events
                if ($this->getAction() == $this->ACTION_DELETE) {
                    $sql .= " delete from tb_field";
                    $sql .= " where " . $jsonUtil->condition("tb_field", "id_module", $this->TYPE_INT, "=", $moduleId);
                    $rs = pg_query($this->cn, $sql);
                    $affectedRows = pg_affected_rows($rs);
                }    

            } catch (Exception $ex) {

                // Keep source and error                
                $this->setError("TableLogic.field()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }

        /*
         * Access control
         */
        private function profileTransaction($moduleId) {

            // General Declaration
            $sql = "";
            $rs = "";
            $json = "";
            $record = "";
            $viewId = 0;
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $model = new Model($this->getGroup());            

            try {

                // Grant for system, admin and user
                switch ($this->getAction()) {

                    case $this->ACTION_NEW:

                        // System
                        $json = $model->addProfileModule($this->PROFILE_SYSTEM, $moduleId);
                        pg_query($this->cn, "insert into tb_profile_table (field) values ('$json')");

                        // Admin
                        $json = $model->addProfileModule($this->PROFILE_ADMIN, $moduleId);
                        pg_query($this->cn, "insert into tb_profile_table (field) values ('$json')");

                        // User
                        $json = $model->addProfileModule($this->PROFILE_USER, $moduleId);
                        pg_query($this->cn, "insert into tb_profile_table (field) values ('$json')");

                        break;

                    case $this->ACTION_DELETE:

                        // Just delete related config
                        $sql = "";
                        $sql .= " delete from tb_profile_table";
                        $sql .= " where " . $jsonUtil->condition("tb_profile_table", "id_module", $this->TYPE_INT, "=", $moduleId);
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

        /*
         * Access control
         */        
        private function tableAction($moduleId) {

            // General Declaration
            $sql = "";
            $rs = "";
            $json = "";
            $record = "";
            $affectedRows = 0;
            $viewId = 0;
            $model = new Model($this->getGroup());
            $jsonUtil = new JsonUtil();

            try {

                // Grant profiles Admin and User
                switch ($this->getAction()) {

                    case $this->ACTION_NEW:

                        // Add standard 7 functions (New, Edit, Delete, Confirm, Filter, Clear, Back)
                        for ($i=1; $i<=3; $i++) {
                            for ($j=1; $j<=7; $j++) {
                                $json = $model->addModuleAction($i, $moduleId, $j);
                                pg_query($this->cn, "insert into tb_module_action (field) values ('$json')");
                            }
                        }
                        break;

                    case $this->ACTION_DELETE:

                        // Remove transaction from Transaction x Function
                        $sql = "";
                        $sql .= " delete from tb_table_action";
                        $sql .= " where " . $jsonUtil->condition("tb_module_action", "id_module", $this->TYPE_INT, "=", $moduleId);
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