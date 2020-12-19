<?php
    class SetupEntity extends Setup {

        /*
         * Create entity module
         */
        public function setup($systemId) {

            try {

                $this->setSystem($systemId);
                $this->createDomain($this->cn);
                $this->createModule($this->cn);

            } catch (Exception $ex) {
                $this->setError("SetupCore.setup()", $ex->getMessage());
                throw $ex;
            }
        }        

        /*
         * Create module and fields
         */
        private function createModule($cn) {

            // General declaration
            $seq = 0;
            $moduleId = 0;
            $model = new Model($this->groupId);            

            try {

                // MENU
                $this->setModule("tb_menu");
                $this->execute($cn, $model->addMenu("Cadastros", 0));

                // MODULES [ENTITY]
                $this->setModule("tb_module");
                $moduleId = $this->execute($cn, $model->addModule("tb_entity", "Pessoas", $this->TYPE_USER, $this->STYLE_TABLE, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_entity");                
                $this->setModule("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Nome", "name", $this->TYPE_TEXT, 50, "", $this->YES, $this->NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo de Entidade", "id_entity_type", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_domain"), $this->fd("value"), "tb_entity_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Tipo de Pessoa", "id_person_type", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_domain"), $this->fd("value"), "tb_person_type", "", $this->INPUT_DROPDOWN, ++$seq));

                // MODULES [ADDRESS]    
                $this->setModule("tb_module");
                $moduleId = $this->execute($cn, $model->addModule("tb_address", "Endereços", $this->TYPE_USER, $this->STYLE_TABLE, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_address");
                $this->setModule("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Pessoa", "id_entity", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo", "id_address_type", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_domain"), $this->fd("value"), "tb_address_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Logradouro", "street", $this->TYPE_TEXT, 500, "", $this->YES, $this->NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Número", "number", $this->TYPE_TEXT, 10, "", $this->YES, $this->NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Compl.", "compl", $this->TYPE_TEXT, 500, "", $this->NO, $this->NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Cep", "zipcode", $this->TYPE_TEXT, 10, "", $this->NO, $this->NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // MODULES [DOCTOS]
                $this->setModule("tb_module");
                $moduleId = $this->execute($cn, $model->addModule("tb_document", "Documentos", $this->TYPE_USER, $this->STYLE_TABLE, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_document");
                $this->setModule("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Pessoa", "id_entity", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo", "id_document_type", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_domain"), $this->fd("value"), "tb_document_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Número", "number", $this->TYPE_TEXT, 50, "", $this->YES, $this->NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // MODULES [CONTACT]
                $this->setModule("tb_module");
                $moduleId = $this->execute($cn, $model->addModule("tb_contact", "Contatos", $this->TYPE_USER, $this->STYLE_TABLE, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_contact");
                $this->setModule("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Pessoa", "id_entity", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo", "id_contact_type", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_domain"), $this->fd("value"), "tb_contact_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Contato", "contact", $this->TYPE_TEXT, 500, "", $this->YES, $this->NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Comentário", "comment", $this->TYPE_TEXT, 5000, "", $this->NO, $this->NO, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));

                // MODULES [ATTACHED]
                $this->setModule("tb_module");
                $moduleId = $this->execute($cn, $model->addModule("tb_attach", "Anexos", $this->TYPE_USER, $this->STYLE_TABLE, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_attach");
                $this->setModule("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Pessoa", "id_entity", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Descrição", "description", $this->TYPE_TEXT, 5000, "", $this->NO, $this->NO, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Arquivo", "attached", $this->TYPE_BINARY, 0, "", $this->NO, $this->NO, 0, 0, "", "", $this->INPUT_FILE, ++$seq));

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create domains
         */
        private function createDomain($cn) {

            // General declaration
            $model = new Model($this->groupId);        

            try {
                
                // Define table name
                $this->setModule("tb_domain");

                // tb_entity_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Clientes", "tb_entity_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Fornecedores", "tb_entity_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "Funcionários", "tb_entity_type"));

                // tb_person_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Física", "tb_person_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Jurídica", "tb_person_type"));

                // tb_address_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Residencial", "tb_address_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Comercial", "tb_address_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "Correspondencia", "tb_address_type"));

                // tb_document_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Rg", "tb_document_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Cpf", "tb_document_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "Cnh", "tb_document_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 4, "Cnpj", "tb_document_type"));

                // tb_contact_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Telefone", "tb_contact_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Email", "tb_contact_type"));                

            } catch (Exception $ex) {
                throw $ex;
            }
        }
        
    } // End of class
?>