<?php
    class LogicSetup extends Setup {

        // Private members
        public $error = "";
        public $systemId = 0;
        public $tableId = 0;

        // Group info
        public $groupId = 1;
        public $admin = 2;
        public $public = 3;

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
            $this->systemId = $systemId;
            $this->setSystem($systemId);

            try {

                // Open connection
                $cn = $this->cn;

                // Database objects
                $this->createSchema($cn);
                $this->createTable($cn);

                // System structure
                $this->createModule($cn);
                $this->createField($cn);
                $this->createDomain($cn);
                $this->createEvent($cn);
                $this->createCode($cn);
                $this->createAction($cn);
                $this->createView($cn);

                // Access control                
                $this->createGroup($cn);
                $this->createUser($cn);
                $this->createUserProfile($cn);
                $this->createProfile($cn);
                $this->createUserGroup($cn);
                $this->createProfileTable($cn);
                $this->createTableAction($cn);


            } catch (Exception $ex) {

                // Keep source and error                
                $this->setError("LogicSetup.setup()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }        

        /*
        * Create tables
        */
        public function createSchema($cn) {

            $systemId = "";
            $schemaName = "";

            try {

                // Create schema for clientes
                $schemaName = $this->systemId;
                pg_query($cn, "drop schema if exists $schemaName cascade");
                pg_query($cn, "create schema if not exists $schemaName");
                pg_query($cn, "set search_path to $schemaName");

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
        * Create tables
        */
        public function createTable($cn) {

            try {

                $table = array();

                // System 
                array_push($table, "tb_menu");
                array_push($table, "tb_table");
                array_push($table, "tb_field");
                array_push($table, "tb_domain");
                array_push($table, "tb_event");
                array_push($table, "tb_action");
                array_push($table, "tb_code");
                array_push($table, "tb_group");
                array_push($table, "tb_view");
                array_push($table, "tb_view_field");
                array_push($table, "tb_profile");
                array_push($table, "tb_profile_table");
                array_push($table, "tb_table_action");
                array_push($table, "tb_user");
                array_push($table, "tb_user_profile");
                array_push($table, "tb_user_group");
                
                for ($i=0; $i<=count($table)-1; $i++) {
                    $tableName = $table[$i];
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
        * Create transactions (menus, tables)
        */
        private function createModule($cn) {

            global $tableName;
            global $total;
            $persist = new Persist();
            $model = new Model($this->groupId);

            // Count control
            $total = 16;

            // Menus
            $MENU_ADM = 101;
            $MENU_SYS = 102;
            $MENU_AC = 103;
            $MENU_CAD = 104;            

            // Module type
            $TYPE_SYSTEM = 1;
            $TYPE_USER = 2;

            try {

                // Set group
                $persist->setGroup($model->groupId);
                $persist->setAction("New");

                // Define table name
                $tableName = "tb_menu";
                $this->execute($cn, $model->addMenu("Administração", 0));
                $this->execute($cn, $model->addMenu("Sistema", $MENU_ADM));
                $this->execute($cn, $model->addMenu("Controle de Acesso", $MENU_ADM));

                // Define table name
                $tableName = "tb_table";

                // CORE
                $this->TB_MENU = $this->execute($cn, $model->addModule("tb_menu", "Menus", $TYPE_SYSTEM, $MENU_SYS));
                $this->TB_TABLE = $this->execute($cn, $model->addModule("tb_table", "Módulos", $TYPE_SYSTEM, $MENU_SYS));
                $this->TB_FIELD = $this->execute($cn, $model->addModule("tb_field", "Campos", $TYPE_SYSTEM, $MENU_SYS));
                $this->TB_DOMAIN = $this->execute($cn, $model->addModule( "tb_domain", "Domínios", $TYPE_SYSTEM, $MENU_SYS));
                $this->TB_EVENT = $this->execute($cn, $model->addModule("tb_event", "Eventos", $TYPE_SYSTEM, $MENU_SYS));
                $this->TB_ACTION = $this->execute($cn, $model->addModule("tb_action", "Ações", $TYPE_SYSTEM, $MENU_SYS));
                $this->TB_CODE = $this->execute($cn, $model->addModule("tb_code", "Programação", $TYPE_SYSTEM, $MENU_SYS));
                $this->TB_VIEW = $this->execute($cn, $model->addModule("tb_view","Visão", $TYPE_SYSTEM,  $MENU_SYS));
                $this->TB_VIEW_FIELD = $this->execute($cn, $model->addModule("tb_view_field", "Visão x Campos", $TYPE_SYSTEM, $MENU_SYS));
                
                // ACCESS CONTROL
                $this->TB_PROFILE = $this->execute($cn, $model->addModule("tb_profile", "Perfil", $TYPE_SYSTEM, $MENU_AC));
                $this->TB_PROFILE_TABLE = $this->execute($cn, $model->addModule("tb_profile_table", "Perfil x Módulo", $TYPE_SYSTEM, $MENU_AC));
                $this->TB_TABLE_ACTION = $this->execute($cn, $model->addModule("tb_table_action", "Módulo x Função", $TYPE_SYSTEM, $MENU_AC));
                $this->TB_USER = $this->execute($cn, $model->addModule("tb_user", "Usuários", $TYPE_SYSTEM, $MENU_AC));
                $this->TB_USER_PROFILE = $this->execute($cn, $model->addModule("tb_user_profile", "Usuários x Pefil", $TYPE_SYSTEM, $MENU_AC));
                $this->TB_GROUP = $this->execute($cn, $model->addModule("tb_group", "Grupos", $TYPE_SYSTEM, $MENU_AC));
                $this->TB_USER_GROUP = $this->execute($cn, $model->addModule("tb_user_group", "Usuários x Grupos", $TYPE_SYSTEM, $MENU_AC));

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
        * Create fields
        */
        private function createField($cn) {

            global $tableName;
            $model = new Model($this->groupId);

            try {

                // Constants
                $seq = 0;
                $yes = 1;
                $no = 2;
                $tableName = "tb_field";

                // tb_domain
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Chave", "key", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Valor", "value", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Domínio", "domain", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_menu
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_MENU, "Nome", "name", $this->TYPE_TEXT, 50, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_MENU, "Pai", "id_parent", $this->TYPE_INT, 0, "", $no, $no, $this->tb("tb_menu"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_table
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_TABLE, "Titulo", "title", $this->TYPE_TEXT, 50, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_TABLE, "Menu", "id_menu", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_menu"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_TABLE, "Tipo", "id_type", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_table_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_TABLE, "Tabela", "name", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_field
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_FIELD, "Módulo", "id_table", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_table"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Rótulo", "label", $this->TYPE_TEXT, 50, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Nome", "name", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Tipo", "id_type", $this->TYPE_TEXT, 50, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_field_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Tamanho", "size", $this->TYPE_INT, 0, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Máscara", "mask", $this->TYPE_TEXT, 50, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Obrigatório", "id_mandatory", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_bool", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Único", "id_unique", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_bool", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Módulo FK", "id_table_fk", $this->TYPE_INT, 0, "", $no, $no, $this->tb("tb_table"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Campo FK", "id_field_fk", $this->TYPE_INT, 0, "", $no, $no, $this->tb("tb_field"), $this->fd("label"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Domínio", "domain", $this->TYPE_TEXT, 50, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Valor Padrão", "default_value", $this->TYPE_TEXT, 50, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Controle", "id_control", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_control", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Ordenação", "ordenation", $this->TYPE_INT, 0, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_view
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_VIEW, "Módulo", "id_table", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_table"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW, "Nome", "name", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW, "Tipo", "id_type", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_view_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW, "SQL", "sql", $this->TYPE_TEXT, 10000, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));

                // tb_view_field
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Visão", "id_view", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_view"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Comando", "id_command", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_command", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Módulo", "id_table", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_table"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Campo", "id_field", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_field"), $this->fd("label"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Descrição", "label", $this->TYPE_TEXT, 50, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Operador", "id_operator", $this->TYPE_INT, 0, "", $no, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_operator", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Valor", "value", $this->TYPE_TEXT, 5000, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_action
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_ACTION, "Nome", "name", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_event
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_EVENT, "Módulo", "id_table", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_table"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Campo", "id_field", $this->TYPE_INT, 0, "", $no, $no, $this->tb("tb_field"), $this->fd("label"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Tela", "id_target", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_target", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Ação", "id_action", $this->TYPE_INT, 0, "", $no, $no, $this->tb("tb_action"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Evento", "id_event", $this->TYPE_INT, 0, "", $no, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_event", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Código", "code", $this->TYPE_TEXT, 10000, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));

                // tb_code
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_CODE, "Comentário", "comment", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_CODE, "Código", "code", $this->TYPE_TEXT, 10000, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));

                // tb_group
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_GROUP, "Nome", "name", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_profile
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_PROFILE, "Nome", "name", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_profile_table
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_PROFILE_TABLE, "Perfil", "id_profile", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_profile"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_PROFILE_TABLE, "Módulo", "id_table", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_table"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_table_action.
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_TABLE_ACTION, "Perfil", "id_profile", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_profile"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_TABLE_ACTION, "Módulo", "id_table", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_table"), $this->fd("title"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_TABLE_ACTION, "Action", "id_action", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_action"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_user
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_USER, "Nome", "name", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER, "Email", "email", $this->TYPE_TEXT, 200, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER, "Usuário", "username", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER, "Password", "password", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_PASSWORD, ++$seq));

                // tb_user_profile
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_USER_PROFILE, "Usuário", "id_user", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_user"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER_PROFILE, "Perfil", "id_profile", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_profile"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_user_group
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_USER_GROUP, "Usuário", "id_user", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_user"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_USER_GROUP, "Grupo", "id_grp", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_group"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
        * Create domain
        */
        private function createDomain($cn) {

            global $tableName;
            $model = new Model($this->groupId);        

            try {
                
                // Define table name
                $tableName = "tb_domain";

                // tb_table_type
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Sistema", "tb_table_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Usuário", "tb_table_type"));
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
                $this->execute($cn, $model->addDomain($this->groupId, "M16", "Perfil do usuário não possui transações associadas", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M17", "Senha inválida ou não informada", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M18", "Autenticado com sucesso, seja bem vindo", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M19", "Módulo não tem nenhum campo associado", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M20", "Não foi possível executar a consulta dinamica", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M21", "Funções Soma, Máximo e Mínimo só são válidas para campos do tipo inteiro, decimal e data", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M22", "Função Média só é válidas para campos do tipo numérico (inteiro e decimal)", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M23", "Operador e Valor devem estar vazios para usar o comando Seleção", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "M24", "Comando Condição selecionado, Operador e Valor são obrigatórios", "tb_message"));

                // tb_cascade
                $this->execute($cn, $model->addDomain($this->groupId, "tb_field.id_table_fk", "id_field_fk; tb_field; id; label", "tb_cascade"));
                $this->execute($cn, $model->addDomain($this->groupId, "tb_event.id_table", "id_field; tb_field; id; label", "tb_cascade"));
                $this->execute($cn, $model->addDomain($this->groupId, "tb_view_field.id_table", "id_field; tb_field; id; label", "tb_cascade"));

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

            $i = 0;
            global $tableName;
            global $total;
            $jsonUtil = new jsonUtil();
            $model = new Model($this->groupId);

            $TABLE = 1;
            $FORM = 2;

            $EVENT_CLICK = 2;

            try {

                // Define table name
                $tableName = "tb_event";

                // Create standard events
                for ($i=1; $i<=$total; $i++) {
                    $this->execute($cn, $model->addEvent($TABLE, $i, 0, 1, $EVENT_CLICK, "formNew();"));
                    $this->execute($cn, $model->addEvent($TABLE, $i, 0, 2, $EVENT_CLICK, "formEdit();"));
                    $this->execute($cn, $model->addEvent($TABLE, $i, 0, 3, $EVENT_CLICK, "formDelete();"));
                    $this->execute($cn, $model->addEvent($TABLE, $i, 0, 4, $EVENT_CLICK, "formDetail();"));
                    $this->execute($cn, $model->addEvent($FORM,  $i, 0, 5, $EVENT_CLICK, "confirm();"));
                    $this->execute($cn, $model->addEvent($TABLE, $i, 0, 6, $EVENT_CLICK, "formFilter();"));
                    $this->execute($cn, $model->addEvent($FORM,  $i, 0, 7, $EVENT_CLICK, "formClear();"));
                    $this->execute($cn, $model->addEvent($FORM,  $i, 0, 8, $EVENT_CLICK, "reportBack();"));
                }

                // Custon events
                $this->execute($cn, $model->addEvent(2, 1, 3, 0, 3, "this.value = formatValue(this.value);"));
                $this->execute($cn, $model->addEvent(2, 2, 5, 0, 3, "this.value = validateTableName(this.value);"));
                $this->execute($cn, $model->addEvent(2, 3, 17, 0, 3, "cascade(''id_field_fk'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'');"));
                $this->execute($cn, $model->addEvent(2, 5, 24, 0, 3, "cascade(''id_field'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'');"));
                $this->execute($cn, $model->addEvent(2, 16, 47, 0, 3, "cascade(''id_field'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'');"));
                $this->execute($cn, $model->addEvent(2, 7, 0, 8, 2, "eval(field(''code'').value);"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
        * Create function
        */
        private function createAction($cn) {

            global $tableName;
            $model = new Model($this->groupId);

            try {

                // Define table name
                $tableName = "tb_action";

                // Create actions
                $this->execute($cn, $model->addFunction("Novo"));
                $this->execute($cn, $model->addFunction("Editar"));
                $this->execute($cn, $model->addFunction("Apagar"));
                $this->execute($cn, $model->addFunction("Detalhe"));
                $this->execute($cn, $model->addFunction("Confirmar"));
                $this->execute($cn, $model->addFunction("Filtrar"));
                $this->execute($cn, $model->addFunction("Limpar"));
                $this->execute($cn, $model->addFunction("Voltar"));
                $this->execute($cn, $model->addFunction("Testar"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
        * Create group
        */
        private function createGroup($cn) {

            global $tableName;
            $model = new Model($this->groupId);

            try {

                // Define table name
                $tableName = "tb_group";

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

            global $tableName;
            $model = new Model($this->groupId);

            try {

                // Define table name
                $tableName = "tb_user";

                // Create User
                $this->execute($cn, $model->addUser($this->groupId, "System", "system@form1.com.br", "system", "123"));
                $this->execute($cn, $model->addUser($this->groupId, "Administrador", "admin@form1.com.br", "admin", "123"));
                $this->execute($cn, $model->addUser($this->public, "João", "joao@form1.com.br", "joao", "123"));
                $this->execute($cn, $model->addUser($this->public, "Maria", "maria@form1.com.br", "maria", "123"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create Profile
         */
        private function createProfile($cn) {

            global $tableName;
            $model = new Model($this->groupId);

            try {

                // Define table name
                $tableName = "tb_profile";

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

            global $tableName;
            $model = new Model($this->groupId);

            try {

                // Define table name
                $tableName = "tb_user_profile";

                // create User Profile
                $this->execute($cn, $model->addUserProfile($this->groupId, 1, 1)); // system-system
                $this->execute($cn, $model->addUserProfile($this->groupId, 2, 2)); // admin-administrador
                $this->execute($cn, $model->addUserProfile($this->public, 3, 3));  // joao-usuario
                $this->execute($cn, $model->addUserProfile($this->public, 4, 3));  // maria-usuario 
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create User x Group
         */
        private function createUserGroup($cn) {

            global $tableName;
            $model = new Model($this->groupId);

            try {

                // Define table name
                $tableName = "tb_user_group";

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
        * Create Profile x Transaction
        */
        private function createProfileTable($cn) {

            $i = 0;
            global $tableName;
            global $total;
            $jsonUtil = new jsonUtil();
            $model = new Model($this->groupId);

            // Profiles
            $SYSTEM = 1;
            $ADMIN = 2;
            $PUBLIC = 3;

            try {

                // Define table name
                $tableName = "tb_profile_table";

                // SYSTEM
                for ($i=1; $i<=$total; $i++) {               
                    $this->execute($cn, $model->addProfileTable($SYSTEM, $i));
                }

                // ADMIN
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_PROFILE));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_PROFILE));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_PROFILE_TABLE));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_TABLE_ACTION));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_USER));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_USER_PROFILE));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_GROUP));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_USER_GROUP));

            } catch (Exception $ex) {
                throw $ex;
            }
        }


        /*
        * Create events
        */
        private function createTableAction($cn) {

            $i = 0;
            $j = 0;

            global $tableName;
            global $total;
            $jsonUtil = new jsonUtil();
            $model = new Model($this->groupId);

            // Profiles
            $SYSTEM = 1;
            $ADMIN = 2;
            $PUBLIC = 3;

            $TOTAL_ACTION = 8;

            try {

                // Define table name
                $tableName = "tb_table_action";

                // SYSTEM has all permissions
                for ($i=1; $i<=$total; $i++) {
                    for ($j=1; $j<=$TOTAL_ACTION; $j++) {
                        $this->execute($cn, $model->addModuleAction($SYSTEM, $i, $j));
                    }
                }

                // ADMIN has Access Control only (11 ... 17)
                for ($i=11; $i<=$total; $i++) {
                    for ($j=1; $j<=$TOTAL_ACTION; $j++) {
                        $this->execute($cn, $model->addModuleAction($ADMIN, $i, $j));
                    }
                }
               
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
        * Create code
        */
        private function createCode($cn) {

            global $tableName;
            $model = new Model($this->groupId);
            
            try {

                // Define table name
                $tableName = "tb_code";

                $this->execute($cn, $model->addCode("Obtem o valor numérico de um campo", "function valor(campo) {\r\n\r\n    value = field(campo).value;\r\n\r\n    if (value.trim() == \"\") {\r\n        value = \"0\";\r\n    }\r\n\r\n    if (!isNumeric(value)) {\r\n        value = \"0\";\r\n    }\r\n\r\n    value = value.split(\".\").join(\"\");\r\n    value = value.split(\",\").join(\".\");\r\n    value = parseFloat(value);\r\n\r\n    return value;\r\n}"));
                $this->execute($cn, $model->addCode("Chamada de pagina customizada", "async function fetchHtmlAsText(url) {\r\n    return await (await fetch(url)).text();\r\n}\r\n\r\nasync function loadExternalPage(url, div) {\r\n    document.getElementById(div).innerHTML = await fetchHtmlAsText(url);\r\n}"));
                $this->execute($cn, $model->addCode("Exemplo de query em banco de dados", "function query(campo) {\r\n\r\n    let rs = query(\"select 1*2 as total\");\r\nalert(rs[0].total);\r\n};"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

       /*
        * Create view
        */
        private function createView($cn) {

            $json = "";
            global $tableName;
            $jsonUtil = new JsonUtil();
            $model = new Model($this->groupId);

            try {

                // Define table name
                $tableName = "tb_view";

                // View to transaction
                //$this->execute($cn, $model->addView("Demo", "select count(*) as name from tb_customer"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        
    } // End of class
?>