<?php
    class Setup extends Base {

        // Generic info
        public $cn = "";
        public $error = "";
        public $systemId = 0;
        public $moduleId = 0;
        public $tableName = "";

        // Group info
        public $groupId = 1;
        public $admin = 2;
        public $public = 3;        

        // Totals
        public $TOTAL_MODULE = 0; 
        public $TOTAL_EVENT = 7;

        // Menus
        public $MENU_ADM = 101;
        public $MENU_SYS = 102;
        public $MENU_AC = 103;
        public $MENU_CAD = 104;

        // Profiles
        public $PROFILE_SYSTEM = 1;
        public $PROFILE_ADMIN = 2;
        public $PROFILE_PUBLIC = 3;

        // Boolean
        public $YES = 1;
        public $NO = 2;

        // Constructor
        function __construct($cn) {
            $this->cn = $cn;
        }

        /*
         * Execute statements
         */        
        public function execute($cn, $json) {

            $id = 0;
            $rs = "";

            try {

                // Insert the record
                $rs = pg_query($cn, "insert into " . $this->tableName . " (field) values ('" . $json . "') returning id");
                
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
        public function tb($tableName) {

            $rs = "";
            $sql = "";
            $moduleId = 0;

            try {

                // Query fields
                $sql .= " select";
                $sql .= " tb_module.id";
                $sql .= " from tb_module";
                $sql .= " where (tb_module.field->>'name')::text = " . "'" . $tableName . "'";
                
                $rs = pg_query($this->cn, $sql);
                while ($row = pg_fetch_row($rs)) {
                    $moduleId = $row[0];
                    $this->tableId = $moduleId;
                    break;
                }
            } catch (Exception $ex) {
                throw $ex;
            }

            return $moduleId;
        }

        /*
         * Get field ID
         */        
        public function fd($fieldName) {

            $rs = "";
            $sql = "";
            $fieldId = 0;

            try {

                // Query fields
                $sql .= " select";
                $sql .= " tb_field.id";
                $sql .= " from tb_field";
                $sql .= " where (tb_field.field->>'id_module')::int = " . $this->tableId;
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

        /*
         * Create events for specific transaction
         */
        public function setupModule($cn, $moduleId, $tableName) {

            // General declaration
            $i = 0;
            $TABLE = 1;
            $FORM = 2;
            $model = new Model($this->groupId);

            try {

                // Related table
                pg_query($cn, "drop table if exists $tableName cascade;");
                pg_query($cn, "create table if not exists $tableName (id serial, field jsonb);");

                // Setup permissions (actions)
                $this->setModule("tb_profile_module");
                for ($j=1; $j<=$this->TOTAL_EVENT; $j++) {
                    $this->execute($cn, $model->addModuleEvent($this->PROFILE_SYSTEM, $moduleId, $j));
                    $this->execute($cn, $model->addModuleEvent($this->PROFILE_ADMIN, $moduleId, $j));
                    $this->execute($cn, $model->addModuleEvent($this->PROFILE_USER, $moduleId, $j));
                }

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function setModule($tableName) {
            $this->tableName = $tableName;
        }
        public function getModule() {
            return $tableName;
        }

        public function setGroup($value) {
            $this->groupId = $value;
        }
        public function getGroup() {
            return $this->groupId;
        }



    } // End of class
?>