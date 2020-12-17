<?php
    class SetupEntity extends Setup {

        /*
         * Upload files
         */
        public function setup($systemId) {

            // General Declaration
            $cn = "";
            $sql = "";
            $rs = "";
            $affectedRows = 0;
            $this->systemId = $systemId;
            $this->setSystem($systemId);

            try {

                // Open connection
                $cn = $this->cn;

                // System structure
                $this->createMenu($cn);
                $this->createModule($cn);
                $this->createField($cn);
                $this->createDomain($cn);
                $this->createEvent($cn);
                $this->createCode($cn);

            } catch (Exception $ex) {
                $this->setError("SetupCore.setup()", $ex->getMessage());
                throw $ex;
            }
        }        

       /*
        * Create menus
        */
        private function createMenu($cn) {

            // General declaration            
            $model = new Model($this->groupId);

            try {

                // MENU
                $this->setTable("tb_menu");
                $this->execute($cn, $model->addMenu("Administração", 0));
                $this->execute($cn, $model->addMenu("Sistema", $this->MENU_ADM));

            } catch (Exception $ex) {
                throw $ex;
            }
        }


        /*
         * Create transactions (menus, tables)
         */
        private function createModule($cn) {

            // General declaration
            $id = 0;
            $model = new Model($this->groupId);            

            // Module type
            $TYPE_SYSTEM = 1;
            $TYPE_USER = 2;

            try {

                // Define target table
                $this->setTable("tb_table");

                // CORE
                $id = $this->execute($cn, $model->addModule("tb_menu", "Menus", $TYPE_SYSTEM, $this->MENU_SYS));
                $this->createEvent($cn, $id);

                // Used to grant access in batch
                $this->TOTAL_MODULE = 16;

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create fields
         */
        private function createField($cn) {

            // General declaration
            $model = new Model($this->groupId);

            try {

                // Constants
                $seq = 0;
                $YES = 1;
                $NO = 2;

                // Set base table
                $this->setTable("tb_field");

                // tb_domain
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Chave", "key", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Valor", "value", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Domínio", "domain", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create domain
         */
        private function createDomain($cn) {

            // General declaration
            $model = new Model($this->groupId);        

            try {
                
                // Define table name
                $this->setTable("tb_domain");

                // tb_table_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Sistema", "tb_table_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Usuário", "tb_table_type"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }




        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //// Do not change methods below
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /*
         * Create events for specific transaction
         */
        private function setupModule($cn, $moduleId) {

            // General declaration
            $i = 0;
            $TABLE = 1;
            $FORM = 2;
            $model = new Model($this->groupId);

            try {

                // Setup events
                $this->setTable("tb_event");
                $this->execute($cn, $model->addEvent($TABLE, $moduleId, 0, 1, $this->EVENT_CLICK, "formNew();"));
                $this->execute($cn, $model->addEvent($TABLE, $moduleId, 0, 2, $this->EVENT_CLICK, "formEdit();"));
                $this->execute($cn, $model->addEvent($TABLE, $moduleId, 0, 3, $this->EVENT_CLICK, "formDelete();"));
                $this->execute($cn, $model->addEvent($TABLE, $moduleId, 0, 4, $this->EVENT_CLICK, "formDetail();"));
                $this->execute($cn, $model->addEvent($FORM,  $moduleId, 0, 5, $this->EVENT_CLICK, "confirm();"));
                $this->execute($cn, $model->addEvent($TABLE, $moduleId, 0, 6, $this->EVENT_CLICK, "formFilter();"));
                $this->execute($cn, $model->addEvent($FORM,  $moduleId, 0, 7, $this->EVENT_CLICK, "formClear();"));
                $this->execute($cn, $model->addEvent($FORM,  $moduleId, 0, 8, $this->EVENT_CLICK, "reportBack();"));

                // Setup permissions (profiles)
                $this->setTable("tb_profile_table");
                $this->execute($cn, $model->addProfileModule($this->PROFILE_SYSTEM, $moduleId));
                $this->execute($cn, $model->addProfileModule($this->PROFILE_ADMIN, $moduleId));
                $this->execute($cn, $model->addProfileModule($this->PROFILE_USER, $moduleId));

                // Setup permissions (actions)
                $this->setTable("tb_table_action");
                for ($j=1; $j<=$this->TOTAL_ACTION; $j++) {
                    $this->execute($cn, $model->addModuleAction($this->PROFILE_SYSTEM, $moduleId, $j));
                    $this->execute($cn, $model->addModuleAction($this->PROFILE_ADMIN, $moduleId, $j));
                    $this->execute($cn, $model->addModuleAction($this->PROFILE_USER, $moduleId, $j));
                }

            } catch (Exception $ex) {
                throw $ex;
            }
        }
        
    } // End of class
?>