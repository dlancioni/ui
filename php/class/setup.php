<?php
    class Setup extends Base {

        // Generic info
        public $cn = "";
        public $error = "";
        public $systemId = 0;
        public $tableId = 0;
        public $tableName = "";

        // Group info
        public $groupId = 1;
        public $admin = 2;
        public $public = 3;        

        // Totals
        public $TOTAL_MODULE = 0; 
        public $TOTAL_ACTION = 8;

        // Menus
        public $MENU_ADM = 101;
        public $MENU_SYS = 102;
        public $MENU_AC = 103;
        public $MENU_CAD = 104;

        // Profiles
        public $PROFILE_SYSTEM = 1;
        public $PROFILE_ADMIN = 2;
        public $PROFILE_PUBLIC = 3;

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
            $tableId = 0;

            try {

                // Query fields
                $sql .= " select";
                $sql .= " tb_table.id";
                $sql .= " from tb_table";
                $sql .= " where (tb_table.field->>'name')::text = " . "'" . $tableName . "'";
                
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
        public function fd($fieldName) {

            $rs = "";
            $sql = "";
            $fieldId = 0;

            try {

                // Query fields
                $sql .= " select";
                $sql .= " tb_field.id";
                $sql .= " from tb_field";
                $sql .= " where (tb_field.field->>'id_table')::int = " . $this->tableId;
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

        public function setTable($tableName) {
            $this->tableName = $tableName;
        }
        public function getTable() {
            return $tableName;
        }        
        
    } // End of class
?>