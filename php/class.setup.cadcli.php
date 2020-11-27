<?php
    class LogicCadCli extends Base {

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

                // System Structure
                $this->createTable($cn);
                $this->createTransaction($cn);
                $this->createField($cn);
                $this->createDomain($cn);
                $this->createEvent($cn);
                $this->createFunction($cn);

                // Access control
                $this->createProfileTable($cn);
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
        public function createTable($cn) {

            try {

                $table = array();
                
                // User
                array_push($table, "tb_customer");
                array_push($table, "tb_address");
                array_push($table, "tb_contact");
                array_push($table, "tb_activity");
                array_push($table, "tb_relationship");
                array_push($table, "tb_file");

                for ($i=0; $i<=count($table)-1; $i++) {
                    $tableName = $table[$i];
                    pg_query($cn, "drop table if exists $tableName cascade;");
                    pg_query($cn, "create table if not exists $tableName (id serial, field jsonb);");
                }

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
                $tableName = "tb_table";

                // System or User
                $TYPE_SYSTEM = 1;
                $TYPE_USER = 2;

                // Menus
                $MENU_ADM = 101;
                $MENU_AC = 102;
                $MENU_CAD = 103;

                // CLIENTES
                $this->TB_CUSTOMER = $this->execute($cn, $model->addTable("tb_customer", "Clientes", $TYPE_USER, $MENU_CAD));
                $this->TB_ADDRESS = $this->execute($cn, $model->addTable("tb_address", "Endereços", $TYPE_USER, $MENU_CAD));
                $this->TB_CONTACT = $this->execute($cn, $model->addTable("tb_contact", "Contatos", $TYPE_USER, $MENU_CAD));
                $this->TB_ACTIVITY = $this->execute($cn, $model->addTable("tb_activity", "Atividades", $TYPE_USER, $MENU_CAD));
                $this->TB_RELATIONSHIP = $this->execute($cn, $model->addTable("tb_relationship", "Relacionamento", $TYPE_USER, $MENU_CAD));
                $this->TB_FILE = $this->execute($cn, $model->addTable("tb_file", "Arquivos", $TYPE_USER, $MENU_CAD));
               
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

                // Constants
                $seq = 0;
                $yes = 1;
                $no = 2;
                $tableName = "tb_field";

                // tb_customer
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_CUSTOMER, "Nome", "name", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_CUSTOMER, "Tipo de Pessoa", "person_type", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_domain"), $this->fd("value"), "tb_person_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_CUSTOMER, "Tipo de Cliente", "client_type", $this->TYPE_TEXT, 50, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_client_type", "", $this->INPUT_DROPDOWN, ++$seq));

                // tb_address
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_ADDRESS, "Cliente", "id_client", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_customer"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_ADDRESS, "Tipo", "address_type", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_domain"), $this->fd("value"), "tb_address_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_ADDRESS, "Logradouro", "street", $this->TYPE_TEXT, 200, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_ADDRESS, "Numero", "number", $this->TYPE_TEXT, 10, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_ADDRESS, "Compl.", "extra", $this->TYPE_TEXT, 10, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_ADDRESS, "Estado", "state", $this->TYPE_TEXT, 10, "", $yes, $no, $this->tb("tb_domain"), $this->fd("value"), "tb_state", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_ADDRESS, "Cidade", "city", $this->TYPE_TEXT, 500, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_ADDRESS, "Bairro", "neighborhood", $this->TYPE_TEXT, 500, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_contact
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_CONTACT, "Cliente", "id_client", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_customer"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_CONTACT, "Tipo", "contact_type", $this->TYPE_INT, 0, "", $yes, $yes, $this->tb("tb_domain"), $this->fd("value"), "tb_contact_type", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_CONTACT, "Valor", "value", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_CONTACT, "Nota", "description", $this->TYPE_TEXT, 50, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                
                // tb_activity
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_ACTIVITY, "Descrição", "description", $this->TYPE_TEXT, 50, "", $yes, $yes, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));

                // tb_relationship
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_RELATIONSHIP, "Cliente", "id_client", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_customer"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_RELATIONSHIP, "Atividade", "id_activity", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_activity"), $this->fd("description"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_RELATIONSHIP, "Data", "date", $this->TYPE_DATE, 0, "dd/mm/yyyy", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_RELATIONSHIP, "Custo", "cost", $this->TYPE_FLOAT, 0, "", $no, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_RELATIONSHIP, "Comentário", "comment", $this->TYPE_TEXT, 10000, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTAREA, ++$seq));
                
                // tb_file
                $seq = 0;
                $this->execute($cn, $model->addField($this->TB_FILE, "Cliente", "id_client", $this->TYPE_INT, 0, "", $yes, $no, $this->tb("tb_customer"), $this->fd("name"), "", "", $this->INPUT_DROPDOWN, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FILE, "Nome", "file_name", $this->TYPE_TEXT, 50, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FILE, "Descrição", "description", $this->TYPE_TEXT, 100, "", $yes, $no, 0, 0, "", "", $this->INPUT_TEXTBOX, ++$seq));
                $this->execute($cn, $model->addField($this->TB_FILE, "Arquivo", "file", $this->TYPE_BINARY, 0, "", $no, $no, 0, 0, "", "", $this->INPUT_FILE, ++$seq));

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

                // person type
                $this->execute($cn, $model->addDomain($this->public, "1", "Física", "tb_person_type"));
                $this->execute($cn, $model->addDomain($this->public, "2", "Jurídica", "tb_person_type"));

                // client type
                $this->execute($cn, $model->addDomain($this->public, "1", "Cliente", "tb_client_type"));
                $this->execute($cn, $model->addDomain($this->public, "2", "Prospect", "tb_client_type"));

                // address type
                $this->execute($cn, $model->addDomain($this->public, "1", "Residencial", "tb_address_type"));
                $this->execute($cn, $model->addDomain($this->public, "2", "Comercial", "tb_address_type"));

                // contact type
                $this->execute($cn, $model->addDomain($this->public, "1", "Email", "tb_contact_type"));
                $this->execute($cn, $model->addDomain($this->public, "2", "Telefone", "tb_contact_type"));

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
                $this->execute($cn, $model->addProfileTable($SYSTEM, $this->TB_CUSTOMER));
                $this->execute($cn, $model->addProfileTable($SYSTEM, $this->TB_ADDRESS));
                $this->execute($cn, $model->addProfileTable($SYSTEM, $this->TB_CONTACT));
                $this->execute($cn, $model->addProfileTable($SYSTEM, $this->TB_ACTIVITY));
                $this->execute($cn, $model->addProfileTable($SYSTEM, $this->TB_RELATIONSHIP));
                $this->execute($cn, $model->addProfileTable($SYSTEM, $this->TB_FILE));                

                // ADMIN
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_CUSTOMER));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_ADDRESS));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_CONTACT));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_ACTIVITY));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_RELATIONSHIP));
                $this->execute($cn, $model->addProfileTable($ADMIN, $this->TB_FILE));

                // PUBLIC
                $this->execute($cn, $model->addProfileTable($PUBLIC, $this->TB_CUSTOMER));
                $this->execute($cn, $model->addProfileTable($PUBLIC, $this->TB_ADDRESS));
                $this->execute($cn, $model->addProfileTable($PUBLIC, $this->TB_CONTACT));
                $this->execute($cn, $model->addProfileTable($PUBLIC, $this->TB_ACTIVITY));
                $this->execute($cn, $model->addProfileTable($PUBLIC, $this->TB_RELATIONSHIP));
                $this->execute($cn, $model->addProfileTable($PUBLIC, $this->TB_FILE));

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

                // PUBLIC
                for ($i=1; $i<=3; $i++) {
                    for ($j=1; $j<=7; $j++) {
                        $this->execute($cn, $model->addTableFunction($i, $this->TB_CUSTOMER, $j));
                        $this->execute($cn, $model->addTableFunction($i, $this->TB_ADDRESS, $j));
                        $this->execute($cn, $model->addTableFunction($i, $this->TB_CONTACT, $j));
                        $this->execute($cn, $model->addTableFunction($i, $this->TB_ACTIVITY, $j));
                        $this->execute($cn, $model->addTableFunction($i, $this->TB_RELATIONSHIP, $j));
                        $this->execute($cn, $model->addTableFunction($i, $this->TB_FILE, $j));
                    }
                }
                
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
                $sql .= " where (tb_table.field->>'id_system')::text = " . $this->getSystem();
                $sql .= " and (tb_table.field->>'name')::text = " . "'" . $tableName . "'";
                
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
                $sql .= " where (tb_field.field->>'id_system')::text = " . $this->getSystem();
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