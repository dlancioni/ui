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

            // General declaration
            $msg = "";
            $data = "";
            $message = "";
            $jsonUtil = new JsonUtil();
            $message = new Message($this->cn);

            try {

                // Validate date fields missing mask
                if ($jsonUtil->getValue($new, "id_style") == $this->STYLE_TABLE) {
                    if (trim($jsonUtil->getValue($new, "name")) == "") {
                        $msg = $message->getValue("M25");
                        throw new Exception($msg);
                    }
                }


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
                $this->actionEvent($id, $new);

                // Delete fields
                $this->field($id);

                // Transaction x Function
                $this->tableAction($id, $new);

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
            $jsonUtil = new JsonUtil();

            try {

                // Handle forms without table
                if ($jsonUtil->getValue($new, "id_style") == $this->STYLE_FORM) {
                    if (trim($jsonUtil->getValue($new, "name")) == "") {
                        return true;
                    }
                }

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
                switch ($this->getEvent()) {
                    
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
        private function actionEvent($moduleId, $new) {

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

            $EVENT_ONCLICK = 2;

            try {

                // Do not create standard actions when form
                if ($jsonUtil->getValue($new, "id_style") == $this->STYLE_FORM) {
                    if (trim($jsonUtil->getValue($new, "name")) == "") {
                        return true;
                    }
                }

                // Grant profiles Admin and User
                switch ($this->getEvent()) {

                    case $this->ACTION_NEW:
                        
                        // New
                        $json = $model->addEvent($this->STYLE_TABLE, $moduleId, 0, 1, $EVENT_ONCLICK, 'formNew();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Edit
                        $json = $model->addEvent($this->STYLE_TABLE, $moduleId, 0, 2, $EVENT_ONCLICK, 'formEdit();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Delete
                        $json = $model->addEvent($this->STYLE_TABLE, $moduleId, 0, 3, $EVENT_ONCLICK, 'formDelete();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Confirm
                        $json = $model->addEvent($this->STYLE_FORM, $moduleId, 0, 4, $EVENT_ONCLICK, 'confirm();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Filter
                        $json = $model->addEvent($this->STYLE_TABLE, $moduleId, 0, 5, $EVENT_ONCLICK, 'formFilter();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Clear
                        $json = $model->addEvent($this->STYLE_FORM, $moduleId, 0, 6, $EVENT_ONCLICK, 'formClear();');
                        pg_query($this->cn, "insert into tb_event (field) values ('$json')");

                        // Back
                        $json = $model->addEvent($this->STYLE_FORM, $moduleId, 0, 7, $EVENT_ONCLICK, 'reportBack();');
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
                if ($this->getEvent() == $this->ACTION_DELETE) {
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
        private function tableAction($moduleId, $new) {

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

                // Do not create standard actions when form
                if ($jsonUtil->getValue($new, "id_style") == $this->STYLE_FORM) {
                    if (trim($jsonUtil->getValue($new, "name")) == "") {
                        return true;
                    }
                }                

                // Grant profiles Admin and User
                switch ($this->getEvent()) {

                    case $this->ACTION_NEW:

                        // Add standard 7 functions (New, Edit, Delete, Confirm, Filter, Clear, Back)
                        for ($i=1; $i<=3; $i++) {
                            for ($j=1; $j<=7; $j++) {
                                $json = $model->addModuleEvent($i, $moduleId, $j);
                                pg_query($this->cn, "insert into tb_module_event (field) values ('$json')");
                            }
                        }
                        break;

                    case $this->ACTION_DELETE:

                        // Remove transaction from Transaction x Function
                        $sql = "";
                        $sql .= " delete from tb_table_action";
                        $sql .= " where " . $jsonUtil->condition("tb_module_event", "id_module", $this->TYPE_INT, "=", $moduleId);
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