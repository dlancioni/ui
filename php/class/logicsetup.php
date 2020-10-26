<?php
    class LogicSetup extends Base {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;
        public $error = "";
        public $systemId = 0;
        public $tableId = 0;

        // Group info
        public $groupId = 1;
        public $admin = 2;
        public $public = 3;

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
        }        

        /*
         * Upload files
         */
        public function setup($systemId) {

            // General Declaration
            $sql = "";
            $rs = "";
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $pathUtil = new PathUtil();
            $this->systemId = $systemId;

            try {

                // DB interface
                $db = new Db();       
                $jsonUtil = new JsonUtil();

                // Open connection
                $cn = $this->cn;

                // System Structure
                $this->createSchema($cn);
                $this->createTable($cn);
                $this->createTransaction($cn);
                $this->createField($cn);
                $this->createDomain($cn);
                $this->createEvent($cn);
                $this->createFunction($cn);
                $this->createGroup($cn);
                $this->createCode($cn);
                $this->createView($cn);
                $this->createFieldSetup($cn);

                // Access control
                $this->createUser($cn);
                $this->createProfile($cn);
                $this->createUserGroup($cn);
                $this->createProfileTable($cn);
                $this->createUserProfile($cn);
                $this->createTableFunction($cn);


            } catch (Exception $ex) {

                // Keep source and error                
                $this->sqlBuilder->setError("LogicSetup.setup()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }        

        /*
        * Create tables
        */
        public function createSchema($cn) {

            $systemId = 0;
            $schemaName = "";

            try {

                $systemId = $this->systemId;

                // Create main schema
                pg_query($cn, "create schema if not exists form1");

                // Create schema for clientes
                $schemaName = "system_$systemId";
                pg_query($cn, "drop schema if exists system_$schemaName");
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
                array_push($table, "tb_function");
                array_push($table, "tb_code");
                array_push($table, "tb_group");
                array_push($table, "tb_view");
                array_push($table, "tb_view_field");
                array_push($table, "tb_profile");
                array_push($table, "tb_profile_table");
                array_push($table, "tb_table_function");
                array_push($table, "tb_user");
                array_push($table, "tb_user_profile");
                array_push($table, "tb_field_attribute");
                array_push($table, "tb_user_group");
                
                // User
                array_push($table, "tb_customer");

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
        private function createTransaction($cn) {

            global $tableName;
            global $total;
            $model = new Model($this->systemId, $this->groupId);
            
            try {

                // Define table name
                $tableName = "tb_menu";
                $this->execute($cn, $model->addMenu("Administração", 0, 1));
                $this->execute($cn, $model->addMenu("Controle de Acesso", 0, 2));
                $this->execute($cn, $model->addMenu("Cadastros", 0, 3));
                
                // Define table name
                $tableName = "tb_table";

                // Count control
                $total = 19;

                // System or User
                $TYPE_SYSTEM = 1;
                $TYPE_USER = 2;

                // Menus
                $MENU_ADM = 101;
                $MENU_AC = 102;
                $MENU_CAD = 103;

                // CORE
                $this->TB_MENU = $this->execute($cn, $model->addTable("Menus", $TYPE_SYSTEM, "tb_menu", $MENU_ADM));
                $this->TB_TABLE = $this->execute($cn, $model->addTable("Transações", $TYPE_SYSTEM,  "tb_table", $MENU_ADM));
                $this->TB_FIELD = $this->execute($cn, $model->addTable("Campos", $TYPE_SYSTEM,  "tb_field", $MENU_ADM));
                $this->TB_DOMAIN = $this->execute($cn, $model->addTable("Domínios", $TYPE_SYSTEM,  "tb_domain", $MENU_ADM));
                $this->TB_EVENT = $this->execute($cn, $model->addTable("Eventos", $TYPE_SYSTEM,  "tb_event", $MENU_ADM));
                $this->TB_FUNCTION = $this->execute($cn, $model->addTable("Funções", $TYPE_SYSTEM,  "tb_function", $MENU_ADM));
                $this->TB_CODE = $this->execute($cn, $model->addTable("Programação", $TYPE_SYSTEM,  "tb_code", $MENU_ADM));
                $this->TB_VIEW = $this->execute($cn, $model->addTable("Visão", $TYPE_SYSTEM,  "tb_view", $MENU_ADM));
                $this->TB_VIEW_FIELD = $this->execute($cn, $model->addTable("Visão x Campos", $TYPE_SYSTEM,  "tb_view_field", $MENU_ADM));
                $this->TB_FIELD_ATTRIBUTE = $this->execute($cn, $model->addTable("Atributos de Campos", $TYPE_SYSTEM,  "tb_field_attribute", $MENU_ADM));

                // ACCESS CONTROL
                $this->TB_PROFILE = $this->execute($cn, $model->addTable("Perfil", $TYPE_SYSTEM,  "tb_profile", $MENU_AC));
                $this->TB_PROFILE_TABLE = $this->execute($cn, $model->addTable("Perfil x Transação", $TYPE_SYSTEM,  "tb_profile_table", $MENU_AC));
                $this->TB_TABLE_FUNCTION = $this->execute($cn, $model->addTable("Transação x Função", $TYPE_SYSTEM,  "tb_table_function", $MENU_AC));
                $this->TB_USER = $this->execute($cn, $model->addTable("Usuários", $TYPE_SYSTEM, "tb_user", $MENU_AC));
                $this->TB_USER_PROFILE = $this->execute($cn, $model->addTable("Usuários x Pefil", $TYPE_SYSTEM,  "tb_user_profile", $MENU_AC));
                $this->TB_GROUP = $this->execute($cn, $model->addTable("Grupos", $TYPE_SYSTEM, "tb_group", $MENU_AC));                
                $this->TB_USER_GROUP = $this->execute($cn, $model->addTable("Usuários x Grupos", $TYPE_SYSTEM,  "tb_user_group", $MENU_AC));

                // CLIENTES
                $this->TB_CUSTOMER = $this->execute($cn, $model->addTable("Clientes", $TYPE_USER,  "tb_customer", $MENU_CAD));
               
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
        * Create fields
        */
        private function createField($cn) {

            global $tableName;
            $model = new Model($this->systemId, $this->groupId);

            try {

                // Datatype
                $int = 1;
                $float = 2;
                $text = 3;
                $date = 4;
                $textarea = 6;
                $password = 8;

                // Constants
                $yes = 1;
                $no = 2;
                $tableName = "tb_field";

                // tb_domain
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Chave", "key", $text, 50, "", $yes, $yes, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Valor", "value", $text, 50, "", $yes, $yes, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_DOMAIN, "Domínio", "domain", $text, 50, "", $yes, $yes, 0, 0, ""));

                // tb_menu                
                $this->execute($cn, $model->addField($this->TB_MENU, "Nome", "name", $text, 50, "", $yes, $no, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_MENU, "Parent", "id_parent", $int, 0, "", $no, $no, $this->tb("tb_menu"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_MENU, "Ordem", "order", $int, 0, "", $yes, $yes, 0, 0, ""));

                // tb_table
                $this->execute($cn, $model->addField($this->TB_TABLE, "Nome", "name", $text, 50, "", $yes, $no, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_TABLE, "Tipo", "id_type", $int, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_table_type"));
                $this->execute($cn, $model->addField($this->TB_TABLE, "Tabela", "table_name", $text, 50, "", $no, $no, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_TABLE, "Menu", "id_menu", $int, 0, "", $no, $no, $this->tb("tb_menu"), $this->fd("name"), ""));

                // tb_field
                $this->execute($cn, $model->addField($this->TB_FIELD, "Tabela", "id_table", $int, 0, "", $yes, $yes, $this->tb("tb_table"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Rótulo", "label", $text, 50, "", $yes, $no, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Tipo", "id_type", $int, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_field_type"));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Tamanho", "size", $int, 0, "", $yes, $no, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Máscara", "mask", $text, 50, "", $no, $no, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Obrigatório", "id_mandatory", $int, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_bool"));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Único", "id_unique", $int, 0, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_bool"));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Tabela FK", "id_table_fk", $int, 0, "", $no, $no, $this->tb("tb_table"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Campo FK", "id_field_fk", $int, 0, "", $no, $no, $this->tb("tb_field"), $this->fd("label"), ""));
                $this->execute($cn, $model->addField($this->TB_FIELD, "Domínio", "domain", $text, 50, "", $no, $no, 0, 0, ""));
                
                // tb_function
                $this->execute($cn, $model->addField($this->TB_FUNCTION, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));

                // tb_event
                $this->execute($cn, $model->addField($this->TB_EVENT, "Tabela", "id_table", $int, 0, "", $yes, $yes, $this->tb("tb_table"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Campo", "id_field", $int, 0, "", $yes, $yes, $this->tb("tb_field"), $this->fd("label"), ""));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Tela", "id_target", $int, 0, "", $yes, $yes, $this->tb("tb_domain"), $this->fd("value"), "tb_target"));                
                $this->execute($cn, $model->addField($this->TB_EVENT, "Ação", "id_function", $int, 0, "", $yes, $yes, $this->tb("tb_function"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Evento", "id_event", $int, 0, "", $yes, $yes, $this->tb("tb_domain"), $this->fd("value"), "tb_event"));
                $this->execute($cn, $model->addField($this->TB_EVENT, "Código", "code", $textarea, 10000, "", $yes, $yes, 0, 0, ""));

                // tb_code
                $this->execute($cn, $model->addField($this->TB_CODE, "Comentário", "comment", $text, 50, "", $yes, $yes, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_CODE, "Código", "code", $textarea, 10000, "", $yes, $yes, 0, 0, ""));

                // tb_group
                $this->execute($cn, $model->addField($this->TB_GROUP, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));

                // tb_view
                $this->execute($cn, $model->addField($this->TB_VIEW, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_VIEW, "SQL", "sql", $textarea, 10000, "", $yes, $yes, 0, 0, ""));

                // tb_view_field
                $this->execute($cn, $model->addField($this->TB_VIEW_FIELD, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));

                // tb_profile                
                $this->execute($cn, $model->addField($this->TB_PROFILE, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));

                // tb_profile_table
                $this->execute($cn, $model->addField($this->TB_PROFILE_TABLE, "Perfil", "id_profile", $int, 0, "", $yes, $yes, $this->tb("tb_profile"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_PROFILE_TABLE, "Transação", "id_table", $int, 0, "", $yes, $yes, $this->tb("tb_table"), $this->fd("name"), ""));

                // tb_table_function
                $this->execute($cn, $model->addField($this->TB_TABLE_FUNCTION, "Perfil", "id_profile", $int, 0, "", $yes, $yes, $this->tb("tb_profile"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_TABLE_FUNCTION, "Transação", "id_table", $int, 0, "", $yes, $yes, $this->tb("tb_table"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_TABLE_FUNCTION, "Function", "id_function", $int, 0, "", $yes, $yes, $this->tb("tb_function"), $this->fd("name"), ""));

                // tb_user
                $this->execute($cn, $model->addField($this->TB_USER, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_USER, "Usuário", "username", $text, 50, "", $yes, $yes, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_USER, "Password", "password", $password, 50, "", $yes, $yes, 0, 0, ""));

                // tb_user_profile
                $this->execute($cn, $model->addField($this->TB_USER_PROFILE, "Usuário", "id_user", $int, 0, "", $yes, $no, $this->tb("tb_user"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_USER_PROFILE, "Perfil", "id_profile", $int, 0, "", $yes, $no, $this->tb("tb_profile"), $this->fd("name"), ""));

                // tb_field_attribute
                $this->execute($cn, $model->addField($this->TB_FIELD_ATTRIBUTE, "Tabela", "id_table", $int, 0, "", $yes, $yes, $this->tb("tb_table"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_FIELD_ATTRIBUTE, "Campo", "id_field", $int, 0, "", $yes, $yes, $this->tb("tb_field"), $this->fd("label"), ""));
                $this->execute($cn, $model->addField($this->TB_FIELD_ATTRIBUTE, "Coluna (%)", "column_size", $int, 0, "", $no, $no, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_FIELD_ATTRIBUTE, "Valor Padrão", "default_value", $int, 0, "", $no, $no, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_FIELD_ATTRIBUTE, "Ordem Tabela", "table_order", $int, 0, "", $no, $no, 0, 0, ""));
                $this->execute($cn, $model->addField($this->TB_FIELD_ATTRIBUTE, "Ordem Formulário", "form_order", $int, 0, "", $no, $no, 0, 0, ""));

                // tb_user_group
                $this->execute($cn, $model->addField($this->TB_USER_GROUP, "Usuário", "id_user", $int, 0, "", $yes, $no, $this->tb("tb_user"), $this->fd("name"), ""));
                $this->execute($cn, $model->addField($this->TB_USER_GROUP, "Grupo", "id_grp", $int, 0, "", $yes, $no, $this->tb("tb_group"), $this->fd("name"), ""));

                // tb_customer
                $this->execute($cn, $model->addField($this->TB_CUSTOMER, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
        * Create domain
        */
        private function createDomain($cn) {

            global $tableName;
            $model = new Model($this->systemId, $this->groupId);        

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
                $this->execute($cn, $model->addDomain($this->groupId, 1, "Inteiro", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 2, "Decimal", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 3, "Texto", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 4, "Data", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 5, "Hora", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 6, "Area", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 7, "Binário", "tb_field_type"));
                $this->execute($cn, $model->addDomain($this->groupId, 8, "Senha", "tb_field_type"));
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
                $this->execute($cn, $model->addDomain($this->groupId, "A1", "Campo % é obrigatório", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A2", "Data inválida informada no campo %", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A3", "Numero inválido informada no campo %", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A4", "Os valores para os campos % ja existem na tabela e não podem se repetir", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A5", "Nenhuma mudança identifica no registro, alteração não realizada", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A6", "Registro incluído com sucesso", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A7", "Registro alterado com sucesso", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A8", "Registro excluído com sucesso", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A9", "Campo Tabela FK foi selecionado, entao Campo FK é obrigatório", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A10", "Transação selecionada é do tipo menu, não é permitido adicionar campos", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A11", "Registro pertence ao grupo Sistema, não pode ser modificado ou excluído", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A12", "Não foi possível concluir o upload dos arquivos", "tb_message"));                
                $this->execute($cn, $model->addDomain($this->groupId, "A13", "Usuário não cadastrado ou não informado", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A14", "Usuário não está associado a nenhum perfil", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A15", "Usuário não está associado a nenhum grupo", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A16", "Perfil do usuário não possui transações associadas", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A17", "Senha inválida ou não informada", "tb_message"));
                $this->execute($cn, $model->addDomain($this->groupId, "A18", "Autenticado com sucesso, seja bem vindo", "tb_message"));
                
                // tb_cascade
                $this->execute($cn, $model->addDomain($this->groupId, "tb_field.id_table_fk", "id_field_fk; tb_field; id; label", "tb_cascade"));
                $this->execute($cn, $model->addDomain($this->groupId, "tb_event.id_table", "id_field; tb_field; id; label", "tb_cascade"));

                // tb_hidden
                $this->execute($cn, $model->addDomain($this->groupId, "1", "Inclusão", "tb_hidden"));
                $this->execute($cn, $model->addDomain($this->groupId, "2", "Alteração", "tb_hidden"));
                $this->execute($cn, $model->addDomain($this->groupId, "3", "Exclusão", "tb_hidden"));
                $this->execute($cn, $model->addDomain($this->groupId, "4", "Sempre", "tb_hidden"));

                // tb_disabled
                $this->execute($cn, $model->addDomain($this->groupId, "1", "Inclusão", "tb_disabled"));
                $this->execute($cn, $model->addDomain($this->groupId, "2", "Alteração", "tb_disabled"));
                $this->execute($cn, $model->addDomain($this->groupId, "3", "Exclusão", "tb_disabled"));
                $this->execute($cn, $model->addDomain($this->groupId, "4", "Sempre", "tb_disabled"));

                // person type
                $this->execute($cn, $model->addDomain($this->public, "1", "Física", "tb_person_type"));
                $this->execute($cn, $model->addDomain($this->public, "2", "Jurídica", "tb_person_type"));

                // client type
                $this->execute($cn, $model->addDomain($this->public, "1", "Cliente", "tb_client_type"));
                $this->execute($cn, $model->addDomain($this->public, "2", "Prospect", "tb_client_type"));

                // address type
                $this->execute($cn, $model->addDomain($this->public, "1", "Residencial", "tb_address_type"));
                $this->execute($cn, $model->addDomain($this->public, "2", "Comercial", "tb_address_type"));

                // States
                $this->execute($cn, $model->addDomain($this->public, "1", "AC", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "2", "AL", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "3", "AP", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "4", "AM", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "5", "BA", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "6", "CE", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "7", "ES", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "8", "GO", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "9", "MA", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "10", "MT", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "11", "MS", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "12", "MG", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "13", "PA", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "14", "PB", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "15", "PR", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "16", "PE", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "17", "PI", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "18", "RJ", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "19", "RN", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "20", "RS", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "21", "RO", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "22", "SC", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "23", "SP", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "24", "SE", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "25", "TO", "tb_state"));
                $this->execute($cn, $model->addDomain($this->public, "26", "DF", "tb_state"));


                
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
            $model = new Model($this->systemId, $this->groupId);

            try {

                // Define table name
                $tableName = "tb_event";

                // Create standard events
                for ($i=1; $i<=$total; $i++) {
                    $this->execute($cn, $model->addEvent(1, $i, 0, 1, 2, "formNew();"));
                    $this->execute($cn, $model->addEvent(1, $i, 0, 2, 2, "formEdit();"));
                    $this->execute($cn, $model->addEvent(1, $i, 0, 3, 2, "formDelete();"));
                    $this->execute($cn, $model->addEvent(2, $i, 0, 4, 2, "confirm();"));
                    $this->execute($cn, $model->addEvent(1, $i, 0, 5, 2, "formFilter();"));
                    $this->execute($cn, $model->addEvent(2, $i, 0, 6, 2, "formClear();"));
                    $this->execute($cn, $model->addEvent(2, $i, 0, 7, 2, "reportBack();"));
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
        private function createFunction($cn) {

            global $tableName;
            $model = new Model($this->systemId, $this->groupId);

            try {

                // Define table name
                $tableName = "tb_function";

                // Create actions
                $this->execute($cn, $model->addFunction("Novo"));
                $this->execute($cn, $model->addFunction("Editar"));
                $this->execute($cn, $model->addFunction("Apagar"));
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
            $model = new Model($this->systemId, $this->groupId);

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
            $model = new Model($this->systemId, $this->groupId);

            try {

                // Define table name
                $tableName = "tb_user";

                // Create User
                $this->execute($cn, $model->addUser($this->groupId, "System", "system", "123"));
                $this->execute($cn, $model->addUser($this->groupId, "Administrador", "admin", "123"));
                $this->execute($cn, $model->addUser($this->public, "João", "joao", "123"));
                $this->execute($cn, $model->addUser($this->public, "Maria", "maria", "123"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create Profile
         */
        private function createProfile($cn) {

            global $tableName;
            $model = new Model($this->systemId, $this->groupId);

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
            $model = new Model($this->systemId, $this->groupId);

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
            $model = new Model($this->systemId, $this->groupId);

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
            $model = new Model($this->systemId, $this->groupId);

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
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_TABLE_FUNCTION));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_USER));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_USER_PROFILE));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_GROUP));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_USER_GROUP));

                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_CUSTOMER));

                // PUBLIC
                $this->execute($cn, $model->addProfileTable($PUBLIC, $this->TB_CUSTOMER));

            } catch (Exception $ex) {
                throw $ex;
            }
        }


        /*
        * Create events
        */
        private function createTableFunction($cn) {

            $i = 0;
            $j = 0;

            global $tableName;
            global $total;
            $jsonUtil = new jsonUtil();
            $model = new Model($this->systemId, $this->groupId);

            // Profiles
            $SYSTEM = 1;
            $ADMIN = 2;
            $PUBLIC = 3;

            try {

                // Define table name
                $tableName = "tb_table_function";

                // SYSTEM has all permissions
                for ($i=1; $i<=$total; $i++) {
                    for ($j=1; $j<=7; $j++) {
                        $this->execute($cn, $model->addTableFunction($SYSTEM, $i, $j));
                    }
                }

                // ADMIN has Access Control only (11 ... 17)
                for ($i=11; $i<=$total; $i++) {
                    for ($j=1; $j<=7; $j++) {
                        $this->execute($cn, $model->addTableFunction($ADMIN, $i, $j));
                    }
                }

                // PUBLIC
                for ($j=1; $j<=7; $j++) {
                    $this->execute($cn, $model->addTableFunction($PUBLIC, $this->TB_CUSTOMER, $j));
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
            $model = new Model($this->systemId, $this->groupId);
            
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
            $model = new Model($this->systemId, $this->groupId);

            try {

                // Define table name
                $tableName = "tb_view";

                // View to transaction
                $this->execute($cn, $model->addView("TransactionByProfileUser", "select distinct tb_table.id, tb_table.field->>''id_parent'' as id_parent, tb_table.field->>''name'' as name, tb_table.field->>''table_name'' as table_name from tb_table inner join tb_profile_table on (tb_profile_table.field->>''id_table'')::int = tb_table.id inner join tb_profile on (tb_profile_table.field->>''id_profile'')::int = tb_profile.id inner join tb_user_profile on (tb_user_profile.field->>''id_profile'')::int = tb_profile.id where (tb_table.field->>''id_system'')::int = p1 and (tb_user_profile.field->>''id_user'')::int = p2 order by tb_table.id"));
                $this->execute($cn, $model->addView("FunctionByProfileUser", "select distinct tb_user_profile.field->>''id_profile'' id_profile, tb_function.id, tb_function.field->>''name'' as name from tb_user_profile inner join tb_table_function on (tb_table_function.field->>''id_profile'')::int = (tb_user_profile.field->>''id_profile'')::int inner join tb_function on (tb_table_function.field->>''id_function'')::int = tb_function.id where (tb_table_function.field->>''id_table'')::int = p1 and (tb_user_profile.field->>''id_user'')::int = p2 order by tb_function.id"));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Create field setup
         */
        private function createFieldSetup($cn) {

            global $tableName;
            $model = new Model($this->systemId, $this->groupId);

            try {

                // Define table name
                $tableName = "tb_field_attribute";

                // tb_menu
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_menu"), $this->fd("name"), 25));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_menu"), $this->fd("id_parent"), 10));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_menu"), $this->fd("order"), 60));
                // tb_table
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_table"), $this->fd("name"), 20));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_table"), $this->fd("id_type"), 20));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_table"), $this->fd("table_name"), 20));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_table"), $this->fd("id_menu"), 35));
                // tb_domain
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_domain"), $this->fd("key"), 10));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_domain"), $this->fd("value"), 40));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_domain"), $this->fd("domain"), 45));
                // tb_function
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_function"), $this->fd("name"), 95));
                // tb_group
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_group"), $this->fd("name"), 95));
                // tb_profile
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_profile"), $this->fd("name"), 95));
                // tb_profile_transaction
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_profile_table"), $this->fd("id_profile"), 10));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_profile_table"), $this->fd("id_table"), 85));
                // tb_transaction_function
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_table_function"), $this->fd("id_profile"), 10));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_table_function"), $this->fd("id_table"), 10));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_table_function"), $this->fd("id_function"), 75));
                // tb_user
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_user"), $this->fd("name"), 10));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_user"), $this->fd("username"), 10));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_user"), $this->fd("password"), 75));
                // tb_user_profile
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_user_profile"), $this->fd("id_user"), 10));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_user_profile"), $this->fd("id_profile"), 85));
                // tb_user_group
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_user_group"), $this->fd("id_user"), 10));
                $this->execute($cn, $model->addFieldSetup($this->tb("tb_user_group"), $this->fd("id_grp"), 85));
                
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Execute statements
         */        
        private function execute($cn, $json) {

            $id = 0;
            $rs = "";
            global $tableName;

            try {

                // Insert the record
                $rs = pg_query($cn, "insert into " . $tableName . " (field) values ('" . $json . "') returning id");
                
                // Get inserted ID
                while ($row = pg_fetch_array($rs)) {
                    $id = $row['id'];
                }

            } catch (Exception $ex) {
                throw $ex;
            }

            // Return generated id
            return $id;
        }

        /*
         * Get table ID
         */        
        private function tb($tableName) {

            $rs = "";
            $sql = "";
            $tableId = 0;

            try {

                // Query fields
                $sql .= " select";
                $sql .= " tb_table.id";
                $sql .= " from tb_table";
                $sql .= " where (tb_table.field->>'id_system')::int = " . $this->systemId;
                $sql .= " and (tb_table.field->>'table_name')::text = " . "'" . $tableName . "'";
                
                $rs = pg_query($this->cn, $sql);
                while ($row = pg_fetch_row($rs)) {
                    $tableId = $row[0];
                    $this->tableId = $tableId;
                    break;
                }
            } catch (Exception $ex) {
                throw $ex;
            }

            return $tableId;
        }

        /*
         * Get field ID
         */        
        private function fd($fieldName) {

            $rs = "";
            $sql = "";
            $fieldId = 0;

            try {

                // Query fields
                $sql .= " select";
                $sql .= " tb_field.id";
                $sql .= " from tb_field";
                $sql .= " where (tb_field.field->>'id_system')::int = " . $this->systemId;
                $sql .= " and (tb_field.field->>'id_table')::int = " . $this->tableId;
                $sql .= " and tb_field.field->>'name' = " . "'" . $fieldName . "'";
                
                $rs = pg_query($this->cn, $sql);
                while ($row = pg_fetch_row($rs)) {
                    $fieldId = $row[0];
                    break;
                }

            } catch (Exception $ex) {
                throw $ex;
            }

            return $fieldId;
        }


    } // End of class
?>