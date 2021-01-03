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
                $this->addData($this->cn);

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
                $this->execute($cn, $model->addField($moduleId, "Nome", "id_entity", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
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
                $this->execute($cn, $model->addField($moduleId, "Nome", "id_entity", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo", "id_document_type", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_domain"), $this->fd("value"), "tb_document_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Número", "number", $this->TYPE_TEXT, 50, "", $this->YES, $this->NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // MODULES [CONTACT]
                $this->setModule("tb_module");
                $moduleId = $this->execute($cn, $model->addModule("tb_contact", "Contatos", $this->TYPE_USER, $this->STYLE_TABLE, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_contact");
                $this->setModule("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Nome", "id_entity", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
                $this->execute($cn, $model->addField($moduleId, "Tipo", "id_contact_type", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_domain"), $this->fd("value"), "tb_contact_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Contato", "contact", $this->TYPE_TEXT, 500, "", $this->YES, $this->NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($moduleId, "Comentário", "comment", $this->TYPE_TEXT, 5000, "", $this->NO, $this->NO, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));

                // MODULES [ATTACHED]
                $this->setModule("tb_module");
                $moduleId = $this->execute($cn, $model->addModule("tb_attach", "Anexos", $this->TYPE_USER, $this->STYLE_TABLE, $this->MENU_CAD));
                $this->setupModule($cn, $moduleId, "tb_attach");
                $this->setModule("tb_field");
                $this->execute($cn, $model->addField($moduleId, "Nome", "id_entity", $this->TYPE_INT, 0, "", $this->YES, $this->NO, $this->tb("tb_entity"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ($seq=1)));
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
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Cliente", "tb_entity_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Fornecedor", "tb_entity_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "Funcionário", "tb_entity_type"));

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

                // tb_contact
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Telefone", "tb_contact_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Email", "tb_contact_type"));

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create data
         */
        private function addData($cn) {

            // General declaration
            $model = new Model($this->groupId);        

            try {
                
                // Entity
                $this->setModule("tb_entity");
                $this->execute($cn, $this->addEntity("João Carlos da Silva", 1, 1));
                $this->execute($cn, $this->addEntity("Loja de materiais S/A", 2, 2));
                $this->execute($cn, $this->addEntity("Ana Maria da Silva", 3, 1));

                // Address
                $this->setModule("tb_address");
                $this->execute($cn, $this->addAddress(1, 1, "Av. Paulista", "1200", "2And 202", "01021-020"));
                $this->execute($cn, $this->addAddress(2, 2, "Av. Rio Branco", "5405", "", "01001-020"));
                $this->execute($cn, $this->addAddress(3, 1, "Rua Antonio Carlos de Souza", "22", "", "08001-020"));

                // Document
                $this->setModule("tb_document");
                $this->execute($cn, $this->addDocument(1, 1, "27.705.777-5"));
                $this->execute($cn, $this->addDocument(2, 4, "03.746.341/0001-07"));
                $this->execute($cn, $this->addDocument(3, 3, "278.705.687-25"));

                // Contact
                $this->setModule("tb_contact");
                $this->execute($cn, $this->addContact(1, 1, "(11) 9 8483-9088", ""));
                $this->execute($cn, $this->addContact(1, 2, "joao.carlos@gmail.com", ""));
                $this->execute($cn, $this->addContact(2, 1, "(11) 5080-1111", "Horário comercial"));
                $this->execute($cn, $this->addContact(2, 2, "atendimento@loja.com.br", ""));
                $this->execute($cn, $this->addContact(3, 1, "(11) 9 8483-9088", ""));

            } catch (Exception $ex) {
                throw $ex;
            }
        }
 
        private function addEntity($name, $id_entity_type, $id_person_type) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "id_entity_type", $id_entity_type);
            $json = $jsonUtil->setValue($json, "id_person_type", $id_person_type);

            // Return final json
            return $json;
        }

        private function addAddress($id_entity, $id_address_type, $street, $number, $compl, $zipcode) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_entity", $id_entity);
            $json = $jsonUtil->setValue($json, "id_address_type", $id_address_type);
            $json = $jsonUtil->setValue($json, "street", $street);
            $json = $jsonUtil->setValue($json, "number", $number);
            $json = $jsonUtil->setValue($json, "compl", $compl);
            $json = $jsonUtil->setValue($json, "zipcode", $zipcode);

            // Return final json
            return $json;
        }

        private function addDocument($id_entity, $id_document_type, $number) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_entity", $id_entity);
            $json = $jsonUtil->setValue($json, "id_document_type", $id_document_type);
            $json = $jsonUtil->setValue($json, "number", $number);

            // Return final json
            return $json;
        }

        private function addContact($id_entity, $id_contact_type, $contact, $comment) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_entity", $id_entity);
            $json = $jsonUtil->setValue($json, "id_contact_type", $id_contact_type);
            $json = $jsonUtil->setValue($json, "contact", $contact);
            $json = $jsonUtil->setValue($json, "comment", $comment);

            // Return final json
            return $json;
        }

        private function addAttached($id_entity, $description, $attached) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_entity", $id_entity);
            $json = $jsonUtil->setValue($json, "description", $description);
            $json = $jsonUtil->setValue($json, "attached", $attached);

            // Return final json
            return $json;
        }


    } // End of class
?>