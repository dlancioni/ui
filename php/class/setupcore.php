<?php
    class SetupCore extends Setup {

        /*
         * Upload files
         */
        public function setup($systemId) {

            // General Declaration
            $cn = "";
            $sql = "";
            $rs = "";
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $pathUtil = new PathUtil();

            try {

                // Open connection
                $cn = $this->cn;

                // Set base system
                $this->setSystem($systemId);                

                // Database objects
                $this->createSchema($cn);
                $this->createTable($cn);
                $this->createFolder($cn);

                // System structure
                $this->createMenu($cn);
                $this->createModule($cn);
                $this->createField($cn);
                $this->createDomain($cn);
                $this->createEvent($cn);
                $this->createCode($cn);

                // Access control                
                $this->createGroup($cn);
                $this->createUser($cn);
                $this->createUserProfile($cn);
                $this->createProfile($cn);
                $this->createUserGroup($cn);
                $this->createModuleEvent($cn);


            } catch (Exception $ex) {
                $this->setError("SetupCore.setup()", $ex->getMessage());
                throw $ex;
            }
        }        

        /*
         * Create tables
         */
        public function createSchema($cn) {

            // General declaration
            $error = "";
            $systemId = "";
            $schemaName = "";

            try {

                // Create schema for clientes
                $schemaName = $this->getSystem();
                pg_query($cn, "drop schema if exists $schemaName cascade");
                pg_query($cn, "create schema if not exists $schemaName");
                pg_query($cn, "set search_path to $schemaName");

            } catch (Exception $ex) {
                $error = "Código de acesso inválido. Use letras e números, sem caractéres especiais ou espaços. Ex.: cadcli, abcbank, loja5";
                throw new Exception($error);
            }
        }

        /*
         * Create tables
         */
        public function createTable($cn) {

            // General declaration
            $module = array();

            try {

                // System 
                array_push($module, "tb_menu");
                array_push($module, "tb_module");
                array_push($module, "tb_field");
                array_push($module, "tb_domain");
                array_push($module, "tb_event");
                array_push($module, "tb_code");
                array_push($module, "tb_group");
                array_push($module, "tb_view");
                array_push($module, "tb_view_field");
                array_push($module, "tb_profile");
                array_push($module, "tb_profile_field");
                array_push($module, "tb_profile_module");
                array_push($module, "tb_user");
                array_push($module, "tb_user_profile");
                array_push($module, "tb_user_group");
                
                for ($i=0; $i<=count($module)-1; $i++) {
                    $tableName = $module[$i];
                    pg_query($cn, "drop table if exists $tableName cascade;");
                    pg_query($cn, "create table if not exists $tableName (id serial, field jsonb);");
                }

                // Due to parent_id, tb_must must start with 100
                pg_query($cn, "alter sequence tb_menu_id_seq restart with 101;");

            } catch (Exception $ex) {
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
                $this->setModule("tb_menu");
                $this->execute($cn, $model->addMenu("Administração", 0));
                $this->execute($cn, $model->addMenu("Sistema", $this->MENU_ADM));
                $this->execute($cn, $model->addMenu("Controle de Acesso", $this->MENU_ADM));

            } catch (Exception $ex) {
                throw $ex;
            }
        }


        /*
         * Create transactions (menus, tables)
         */
        private function createModule($cn) {

            // General declaration
            $model = new Model($this->groupId);            

            try {

                // Define target table
                $this->setModule("tb_module");

                // CORE
                $this->TB_MENU = $this->execute($cn, $model->addModule("tb_menu", "Menus", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_SYS));
                $this->TB_MODULE = $this->execute($cn, $model->addModule("tb_module", "Módulos", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_SYS));
                $this->TB_FIELD = $this->execute($cn, $model->addModule("tb_field", "Campos", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_SYS));
                $this->TB_DOMAIN = $this->execute($cn, $model->addModule( "tb_domain", "Domínios", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_SYS));
                $this->TB_EVENT = $this->execute($cn, $model->addModule("tb_event", "Eventos", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_SYS));
                $this->TB_CODE = $this->execute($cn, $model->addModule("tb_code", "Programação", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_SYS));
                $this->TB_VIEW = $this->execute($cn, $model->addModule("tb_view","Visão", $this->TYPE_SYSTEM,  $this->STYLE_TABLE, $this->MENU_SYS));
                $this->TB_VIEW_FIELD = $this->execute($cn, $model->addModule("tb_view_field", "Visão x Campos", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_SYS));
                
                // ACCESS CONTROL
                $this->TB_PROFILE = $this->execute($cn, $model->addModule("tb_profile", "Perfil", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_AC));
                $this->TB_PROFILE_MODULE = $this->execute($cn, $model->addModule("tb_profile_module", "Perfil x Módulo", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_AC));
                $this->TB_USER = $this->execute($cn, $model->addModule("tb_user", "Usuários", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_AC));
                $this->TB_USER_PROFILE = $this->execute($cn, $model->addModule("tb_user_profile", "Usuários x Pefil", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_AC));
                $this->TB_GROUP = $this->execute($cn, $model->addModule("tb_group", "Grupos", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_AC));
                $this->TB_USER_GROUP = $this->execute($cn, $model->addModule("tb_user_group", "Usuários x Grupos", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_AC));
                $this->TB_PROFILE_FIELD = $this->execute($cn, $model->addModule("tb_profile_field", "Perfil x Campos", $this->TYPE_SYSTEM, $this->STYLE_TABLE, $this->MENU_AC));                                
                $this->TB_UPD_PWD = $this->execute($cn, $model->addModule("", "Alterar senha", $this->TYPE_SYSTEM, $this->STYLE_FORM, $this->MENU_AC));

                // Used to grant access in batch
                $this->TOTAL_MODULE = 17;

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
                $this->setModule("tb_field");

                // tb_domain
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Chave", "key", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Valor", "value", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Domínio", "domain", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_menu
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_MENU, "Nome", "name", $this->TYPE_TEXT, 50, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_MENU, "Pai", "id_parent", $this->TYPE_INT, 0, "", $NO, $NO, $this->tb("tb_menu"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_module
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_MODULE, "Titulo", "title", $this->TYPE_TEXT, 50, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_MODULE, "Menu", "id_menu", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_menu"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_MODULE, "Tipo", "id_type", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_module_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_MODULE, "Estilo", "id_style", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_module_style", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_MODULE, "Tabela", "name", $this->TYPE_TEXT, 50, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_field
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_FIELD, "Módulo", "id_module", $this->TYPE_INT, 0, "", $YES, $YES, $this->tb("tb_module"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Rótulo", "label", $this->TYPE_TEXT, 50, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Nome", "name", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Tipo", "id_type", $this->TYPE_TEXT, 50, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_field_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Tamanho", "size", $this->TYPE_INT, 0, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Máscara", "mask", $this->TYPE_TEXT, 50, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Obrigatório", "id_mandatory", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_bool", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Único", "id_unique", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_bool", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Módulo FK", "id_module_fk", $this->TYPE_INT, 0, "", $NO, $NO, $this->tb("tb_module"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Campo FK", "id_field_fk", $this->TYPE_INT, 0, "", $NO, $NO, $this->tb("tb_field"), $this->fd("label"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Domínio", "domain", $this->TYPE_TEXT, 50, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Valor Padrão", "default_value", $this->TYPE_TEXT, 50, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Controle", "id_control", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_control", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Ordenação", "ordenation", $this->TYPE_INT, 0, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_view
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_VIEW, "Módulo", "id_module", $this->TYPE_INT, 0, "", $YES, $YES, $this->tb("tb_module"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW, "Nome", "name", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW, "Tipo", "id_type", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_view_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW, "Paginação", "paged", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_bool", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW, "SQL", "sql", $this->TYPE_TEXT, 10000, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));

                // tb_view_field
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Visão", "id_view", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_view"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Comando", "id_command", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_command", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Módulo", "id_module", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_module"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Campo", "id_field", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_field"), $this->fd("label"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Descrição", "label", $this->TYPE_TEXT, 50, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Operador", "id_operator", $this->TYPE_INT, 0, "", $NO, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_operator", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Valor", "value", $this->TYPE_TEXT, 5000, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_event
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_EVENT, "Módulo", "id_module", $this->TYPE_INT, 0, "", $NO, $NO, $this->tb("tb_module"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));                
                $this->execute($cn, $model->addField($this->TB_EVENT, "Tela", "id_target", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_target", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Name", "name", $this->TYPE_TEXT, 50, "", $NO, $NO, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Evento", "id_event", $this->TYPE_INT, 0, "", $NO, $NO, $this->tb("tb_domain"), $this->fd("value"), "tb_event", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Campo", "id_field", $this->TYPE_INT, 0, "", $NO, $NO, $this->tb("tb_field"), $this->fd("label"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Código", "code", $this->TYPE_TEXT, 10000, "", $YES, $NO, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));

                // tb_code
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_CODE, "Comentário", "comment", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_CODE, "Código", "code", $this->TYPE_TEXT, 10000, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));

                // tb_group
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_GROUP, "Nome", "name", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_profile
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_PROFILE, "Nome", "name", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_profile_field
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_PROFILE_FIELD, "Perfil", "id_profile", $this->TYPE_INT, 0, "", $YES, $YES, $this->tb("tb_profile"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_PROFILE_FIELD, "Módulo", "id_module", $this->TYPE_INT, 0, "", $YES, $YES, $this->tb("tb_module"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_PROFILE_FIELD, "Campo", "id_field", $this->TYPE_INT, 0, "", $YES, $YES, $this->tb("tb_field"), $this->fd("label"), "", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_profile_module
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_PROFILE_MODULE, "Perfil", "id_profile", $this->TYPE_INT, 0, "", $YES, $YES, $this->tb("tb_profile"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_PROFILE_MODULE, "Módulo", "id_module", $this->TYPE_INT, 0, "", $YES, $YES, $this->tb("tb_module"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_PROFILE_MODULE, "Evento", "id_event", $this->TYPE_INT, 0, "", $YES, $YES, $this->tb("tb_event"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_user
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_USER, "Nome", "name", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER, "Email", "email", $this->TYPE_TEXT, 200, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER, "Usuário", "username", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER, "Password", "password", $this->TYPE_TEXT, 50, "", $YES, $YES, 0, 0, "", "", $this->INPUT_PASSWORD, ++$seq));

                // tb_user_profile
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_USER_PROFILE, "Usuário", "id_user", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_user"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER_PROFILE, "Perfil", "id_profile", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_profile"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_user_group
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_USER_GROUP, "Usuário", "id_user", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_user"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER_GROUP, "Grupo", "id_grp", $this->TYPE_INT, 0, "", $YES, $NO, $this->tb("tb_group"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_user
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_UPD_PWD, "Senha atual", "current", $this->TYPE_TEXT, 50, "", $YES, $NO, 0, 0, "", "", $this->INPUT_PASSWORD, ++$seq));
                $this->execute($cn, $model->addField($this->TB_UPD_PWD, "Nova senha", "new", $this->TYPE_TEXT, 50, "", $YES, $NO, 0, 0, "", "", $this->INPUT_PASSWORD, ++$seq));
                $this->execute($cn, $model->addField($this->TB_UPD_PWD, "Confirme a nova senha", "confirm", $this->TYPE_TEXT, 50, "", $YES, $NO, 0, 0, "", "", $this->INPUT_PASSWORD, ++$seq));

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
                
                // Define module name
                $this->setModule("tb_domain");

                // tb_module_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Sistema", "tb_module_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Usuário", "tb_module_type"));

                // tb_module_style
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Tabela", "tb_module_style"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Formulário", "tb_module_style"));

                // tb_bool
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Sim", "tb_bool"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Não", "tb_bool"));

                // tb_field_type
                $this->execute($cn, $model->addDomain($this->groupId, $this->TYPE_INT, "Inteiro", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, $this->TYPE_FLOAT, "Decimal", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, $this->TYPE_TEXT, "Texto", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, $this->TYPE_DATE, "Data", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, $this->TYPE_TIME, "Hora", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, $this->TYPE_BINARY, "Binario", "tb_field_type"));

                // tb_event
                $this->execute($cn, $model->addDomain($this->groupId, 1, "onLoad", "tb_event"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "onClick", "tb_event"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "OnChange", "tb_event"));
                $this->execute($cn, $model->addDomain($this->groupId, 4, "onFocus", "tb_event"));
                $this->execute($cn, $model->addDomain($this->groupId, 5, "onBlur", "tb_event"));

                // tb_target
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Tabela", "tb_target"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Formulário", "tb_target"));

                // tb_message
                $this->execute($cn, $model->addDomain($this->groupId, "M1", "Campo % é obrigatório", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M2", "Data inválida informada no campo %", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M3", "Numero inválido informada no campo %", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M4", "Os valores para os campos % ja existem na tabela e não podem se repetir", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M5", "Nenhuma mudança identifica no registro, alteração não realizada", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M6", "Registro incluído com sucesso", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M7", "Registro alterado com sucesso", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M8", "Registro excluído com sucesso", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M9", "Campo Tabela FK foi selecionado, entao Campo FK é obrigatório", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M10", "Campo % é do tipo data, mascara é obrigatório. ex: dd/mm/yyyy", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M11", "Registro pertence ao grupo Sistema, não pode ser modificado ou excluído", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M12", "Não foi possível concluir o upload dos arquivos", "tb_message"));                
                $this->execute($cn, $model->addDomain($this->groupId, "M13", "Usuário não cadastrado ou não informado", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M14", "Usuário não está associado a nenhum perfil", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M15", "Usuário não está associado a nenhum grupo", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M16", "Perfil do usuário não possui módulos associadas", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M17", "Senha inválida ou não informada", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M18", "Autenticado com sucesso, seja bem vindo", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M19", "Módulo não tem nenhum campo associado ou permissionado", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M20", "Não foi possível executar a consulta dinamica", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M21", "Funções Soma, Máximo e Mínimo só são válidas para campos do tipo inteiro, decimal e data", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M22", "Função Média só é válidas para campos do tipo numérico (inteiro e decimal)", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M23", "Operador e Valor devem estar vazios para usar o comando Seleção", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M24", "Comando Condição selecionado, Operador e Valor são obrigatórios", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M25", "Módulos de estilo tabela com nome de tabela inválido ou vazio", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M26", "Senha alterada com sucesso", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M27", "Nova senha não está confirmada corretamente", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M28", "Senha atual informada inválida", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M29", "Usuário % já está logado no sistema", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M30", "Registro não pode ser excluído, existem dados relacionados no módulo %", "tb_message"));

                // tb_cascade
                $this->execute($cn, $model->addDomain($this->groupId, "tb_field.id_module_fk", "id_field_fk; tb_field; id; label", "tb_cascade"));
                $this->execute($cn, $model->addDomain($this->groupId, "tb_event.id_module", "id_field; tb_field; id; label", "tb_cascade"));
                $this->execute($cn, $model->addDomain($this->groupId, "tb_view_field.id_module", "id_field; tb_field; id; label", "tb_cascade"));
                $this->execute($cn, $model->addDomain($this->groupId, "tb_profile_field.id_module", "id_field; tb_field; id; label", "tb_cascade"));

                // tb_control
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Textbox", "tb_control"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Dropdown", "tb_control"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "Textarea", "tb_control"));
                $this->execute($cn, $model->addDomain($this->groupId, 4, "Upload", "tb_control"));
                $this->execute($cn, $model->addDomain($this->groupId, 5, "Hidden", "tb_control"));
                $this->execute($cn, $model->addDomain($this->groupId, 6, "Password", "tb_control"));

                // tb_command
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Selecionar", "tb_command"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Contar", "tb_command"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "Somatória", "tb_command"));
                $this->execute($cn, $model->addDomain($this->groupId, 4, "Máximo", "tb_command"));
                $this->execute($cn, $model->addDomain($this->groupId, 5, "Mínimo", "tb_command"));
                $this->execute($cn, $model->addDomain($this->groupId, 6, "Média", "tb_command"));
                $this->execute($cn, $model->addDomain($this->groupId, 7, "Condição", "tb_command"));
                $this->execute($cn, $model->addDomain($this->groupId, 8, "Ordenar Asc", "tb_command"));
                $this->execute($cn, $model->addDomain($this->groupId, 9, "Ordenar Desc", "tb_command"));

                // tb_operator
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Igual", "tb_operator"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Diferente", "tb_operator"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "Maior", "tb_operator"));
                $this->execute($cn, $model->addDomain($this->groupId, 4, "Maior igual", "tb_operator"));
                $this->execute($cn, $model->addDomain($this->groupId, 5, "Menor", "tb_operator"));
                $this->execute($cn, $model->addDomain($this->groupId, 6, "Menor igual", "tb_operator"));

                // tb_chart_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Relatório", "tb_view_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Linha", "tb_view_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "Barra", "tb_view_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 4, "Área", "tb_view_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 5, "Pizza", "tb_view_type"));                
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create events
         */
        private function createEvent($cn) {

            // General declaration
            $i = 0;
            $TABLE = 1;
            $FORM = 2;
            $model = new Model($this->groupId);

            try {

                // Define module name
                $this->setModule("tb_event");

                // Create standard events
                $this->execute($cn, $model->addEvent($TABLE, "Novo", $this->EVENT_CLICK, 0, 0, "formNew();"));
                $this->execute($cn, $model->addEvent($TABLE, "Editar", $this->EVENT_CLICK, 0, 0, "formEdit();"));
                $this->execute($cn, $model->addEvent($TABLE, "Apagar", $this->EVENT_CLICK, 0, 0, "formDelete();"));
                $this->execute($cn, $model->addEvent($FORM, "Confirmar", $this->EVENT_CLICK, 0, 0, "confirm();"));
                $this->execute($cn, $model->addEvent($TABLE, "Filtrar", $this->EVENT_CLICK, 0, 0, "formFilter();"));
                $this->execute($cn, $model->addEvent($FORM, "Limpar", $this->EVENT_CLICK, 0, 0, "formClear();"));
                $this->execute($cn, $model->addEvent($FORM, "Voltar", $this->EVENT_CLICK, 0, 0, "reportBack();"));
                $this->execute($cn, $model->addEvent($FORM, "Alterar senha", $this->EVENT_CLICK, 0, 0, "changePassword();"));
                
                // Custon events
                $this->execute($cn, $model->addEvent($FORM, "", $this->EVENT_CHANGE, $this->tb("tb_module"), $this->fd("name"), "this.value = validateTableName(this.value);"));
                $this->execute($cn, $model->addEvent($FORM, "Testar", $this->EVENT_CLICK, 0, 0, "eval(field(''code'').value);"));

                /*
                $this->execute($cn, $model->addEvent($FORM, "", $this->EVENT_CHANGE, $this->tb("tb_field"), $this->fd("id_field_fk"), "cascade(''id_field_fk'', ''id_module'', this.value, ''tb_field'', ''id'', ''label'');"));
                $this->execute($cn, $model->addEvent($FORM, "", $this->EVENT_CHANGE, $this->tb("tb_event"), $this->fd("id_field"), "cascade(''id_field'', ''id_module'', this.value, ''tb_field'', ''id'', ''label'');"));
                $this->execute($cn, $model->addEvent($FORM, "", $this->EVENT_CHANGE, $this->tb("tb_profile_field"), $this->fd("id_field"), "cascade(''id_field'', ''id_module'', this.value, ''tb_field'', ''id'', ''label'');"));                
                */

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create group
         */
        private function createGroup($cn) {

            // General declaration
            $model = new Model($this->groupId);

            try {

                // Define module name
                $this->setModule("tb_group");

                // Create groups
                $this->execute($cn, $model->addGroup("Sistema"));           // 1) Change structure 2) No restrictions on view
                $this->execute($cn, $model->addGroup("Administrador"));     // 2) No restrictions on view
                $this->execute($cn, $model->addGroup("Público"));           // 3) Restricted on view
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create User
         */
        private function createUser($cn) {

            // General declaration
            $model = new Model($this->groupId);

            try {

                // Define module name
                $this->setModule("tb_user");

                // Create User
                $this->execute($cn, $model->addUser($this->groupId, "System", "system@form1.com.br", "system", "system@forms"));
                $this->execute($cn, $model->addUser($this->groupId, "Administrador", "admin@form1.com.br", "admin", "admin@forms"));
                $this->execute($cn, $model->addUser($this->public, "Usuário", "usuario@form1.com.br", "usuario", ""));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create Profile
         */
        private function createProfile($cn) {

            // General declaration
            $model = new Model($this->groupId);

            try {

                // Define module name
                $this->setModule("tb_profile");

                // Create Profile
                $this->execute($cn, $model->addProfile("System"));
                $this->execute($cn, $model->addProfile("Administrador"));
                $this->execute($cn, $model->addProfile("Usuário"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create User x Profile
         */
        private function createUserProfile($cn) {

            // General declaration            
            $model = new Model($this->groupId);

            try {

                // Define module name
                $this->setModule("tb_user_profile");

                // create User Profile
                $this->execute($cn, $model->addUserProfile($this->groupId, 1, 1)); // system-system
                $this->execute($cn, $model->addUserProfile($this->groupId, 2, 2)); // admin-administrador
                $this->execute($cn, $model->addUserProfile($this->public, 3, 3));  // usuario-usuario
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create User x Group
         */
        private function createUserGroup($cn) {

            // General declaration            
            $model = new Model($this->groupId);

            try {

                // Define module name
                $this->setModule("tb_user_group");

                // create User Profile (cannot add permission to group 1)
                $this->execute($cn, $model->addUserGroup($this->groupId, 1, 1)); // System 
                $this->execute($cn, $model->addUserGroup($this->groupId, 2, 2)); // Admin
                $this->execute($cn, $model->addUserGroup($this->public, 3, 3));  // Joao  
                $this->execute($cn, $model->addUserGroup($this->public, 4, 3));  // Maria
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }        

        /*
         * Create events
         */
        private function createModuleEvent($cn) {

            // General declaration
            $i = 0;
            $j = 0;
            $EVENT_CLEAR = 6;
            $EVENT_CHANGE_PASSWORD = 8;
            $model = new Model($this->groupId);

            try {

                // Define module name
                $this->setModule("tb_profile_module");

                // SYSTEM has all permissions
                for ($i=1; $i<=$this->TOTAL_MODULE; $i++) {
                    if ($i != $this->TB_UPD_PWD) {
                        for ($j=1; $j<=$this->TOTAL_EVENT; $j++) {
                            $this->execute($cn, $model->addModuleEvent($this->PROFILE_SYSTEM, $i, $j));
                        }
                    }
                }

                // ADMIN has access control only (10...17)
                for ($i=10; $i<=$this->TOTAL_MODULE; $i++) {
                    if ($i != $this->TB_UPD_PWD) {
                        for ($j=1; $j<=$this->TOTAL_EVENT; $j++) {
                            $this->execute($cn, $model->addModuleEvent($this->PROFILE_ADMIN, $i, $j));
                        }
                    }
                }

                // Custon for change password screen
                $this->execute($cn, $model->addModuleEvent($this->PROFILE_SYSTEM, $this->TB_UPD_PWD, $EVENT_CHANGE_PASSWORD));
                $this->execute($cn, $model->addModuleEvent($this->PROFILE_ADMIN, $this->TB_UPD_PWD, $EVENT_CHANGE_PASSWORD));
                $this->execute($cn, $model->addModuleEvent($this->PROFILE_USER, $this->TB_UPD_PWD, $EVENT_CHANGE_PASSWORD));

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create code
         */
        private function createCode($cn) {

            // General declaration
            $model = new Model($this->groupId);
            
            try {

                // Define module name
                $this->setModule("tb_code");

                // Add records
                $this->execute($cn, $model->addCode("Obtem o valor numérico de um campo", "function valor(campo) {\r\n\r\n    value = field(campo).value;\r\n\r\n    if (value.trim() == \"\") {\r\n        value = \"0\";\r\n    }\r\n\r\n    if (!isNumeric(value)) {\r\n        value = \"0\";\r\n    }\r\n\r\n    value = value.split(\".\").join(\"\");\r\n    value = value.split(\",\").join(\".\");\r\n    value = parseFloat(value);\r\n\r\n    return value;\r\n}"));
                $this->execute($cn, $model->addCode("Chamada de pagina customizada", "async function fetchHtmlAsText(url) {\r\n    return await (await fetch(url)).text();\r\n}\r\n\r\nasync function loadExternalPage(url, div) {\r\n    document.getElementById(div).innerHTML = await fetchHtmlAsText(url);\r\n}"));
                $this->execute($cn, $model->addCode("Exemplo de query em banco de dados", "function query(campo) {\r\n\r\n    let rs = query(\"select 1*2 as total\");\r\nalert(rs[0].total);\r\n};"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create area to upload files
         */
        private function createFolder($cn) {

            // General declaration
            $path = "";
            $fileUtil = new FileUtil();
            $pathUtil = new PathUtil();
            $model = new Model($this->getGroup());
            
            try {

                // Log folder 
                $path = $pathUtil->getLogPath("");
                $fileUtil->createDirectory($path);
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }



        
    } // End of class
?>