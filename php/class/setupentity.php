<?php
    class SetupEntity extends Setup {

        /*
         * Upload files
         */
        public function setup($systemId) {

            // General Declaration
            $cn = "";
            $this->systemId = $systemId;
            $this->setSystem($systemId);

            try {

                // Open connection
                $cn = $this->cn;

                // System structure
                $this->createDomain($cn);
                $this->createModule($cn);                

            } catch (Exception $ex) {
                $this->setError("SetupCore.setup()", $ex->getMessage());
                throw $ex;
            }
        }        

        /*
         * Create transactions (menus, tables)
         */
        private function createModule($cn) {

            // General declaration
            $seq = 0;
            $YES = 1;
            $NO = 2;
            $moduleId = 0;
            $model = new Model($this->groupId);            

            // Module type
            $TYPE_SYSTEM = 1;
            $TYPE_USER = 2;

            try {

                // MENU
                $this->setTable("tb_menu");
                $this->execute($cn, $model->addMenu("Cadastros", 0));

                // MODULES [ENTITY]
                $this->setTable("tb_table");
                $moduleId = $this->execute($cn, $model->addModule("tb_entity", "Pessoas", $TYPE_USER, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_entity");                
                $this->setTable("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Nome", "name", $this->TYPE_TEXT, 50, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo de Entidade", "id_entity_type", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_entity_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Tipo de Pessoa", "id_person_type", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_person_type", "", $this->INPUT_DROPDOWN, ++$seq));

                // MODULES [ADDRESS]    
                $this->setTable("tb_table");
                $moduleId = $this->execute($cn, $model->addModule("tb_address", "Endereços", $TYPE_USER, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_address");
                $this->setTable("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Pessoa", "id_entity", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo", "id_address_type", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_address_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Logradouro", "street", $this->TYPE_TEXT, 500, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Número", "number", $this->TYPE_TEXT, 10, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Compl.", "compl", $this->TYPE_TEXT, 500, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Cep", "zipcode", $this->TYPE_TEXT, 10, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // MODULES [DOCTOS]
                $this->setTable("tb_table");
                $moduleId = $this->execute($cn, $model->addModule("tb_document", "Documentos", $TYPE_USER, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_document");
                $this->setTable("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Pessoa", "id_entity", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo", "id_document_type", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_document_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Número", "number", $this->TYPE_TEXT, 50, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // MODULES [CONTACT]
                $this->setTable("tb_table");
                $moduleId = $this->execute($cn, $model->addModule("tb_contact", "Contatos", $TYPE_USER, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_contact");
                $this->setTable("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Pessoa", "id_entity", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo", "id_contact_type", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_contact_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Documento", "document", $this->TYPE_TEXT, 500, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Obs", "comment", $this->TYPE_TEXT, 5000, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));

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

                // tb_entity_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Clientes", "tb_entity_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Fornecedores", "tb_entity_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Funcionários", "tb_entity_type"));

                // tb_person_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Física", "tb_person_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Jurídica", "tb_person_type"));

                // tb_address_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Residencial", "tb_address_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Comercial", "tb_address_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Correspondencia", "tb_address_type"));

                // tb_document_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "RG", "tb_document_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "CPF", "tb_document_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "CNH", "tb_document_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 4, "CNPJ", "tb_document_type"));

                // tb_contact_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Telefone", "tb_contact_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Email", "tb_contact_type"));                
                

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
        private function setupModule($cn, $moduleId, $tableName) {

            // General declaration
            $i = 0;
            $TABLE = 1;
            $FORM = 2;
            $model = new Model($this->groupId);

            try {

                // Related table
                pg_query($cn, "drop table if exists $tableName cascade;");
                pg_query($cn, "create table if not exists $tableName (id serial, field jsonb);");

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