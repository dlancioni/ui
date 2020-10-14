<?php
    class Model extends Base {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;
        public $html;

        // Constructor
        function __construct() {

        }

        public function addSystem($id_system, $name, $expire_date, $price) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "expire_date", $expire_date);
            $json = $jsonUtil->setValue($json, "price", $price);

            // Return final json
            return $json;
        }

        public function addTable($id_system, $name, $id_type, $table_name, $id_parent) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "id_type", $id_type);
            $json = $jsonUtil->setValue($json, "table_name", $table_name);
            $json = $jsonUtil->setValue($json, "id_parent", $id_parent);

            // Return final json
            return $json;
        }

        public function addField($id_system, $id_table, $label, $name, $id_type, $size, $mask, $id_mandatory, $id_unique, $id_table_fk, $id_field_fk, $domain) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_table", $id_table);
            $json = $jsonUtil->setValue($json, "label", $label);
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "id_type", $id_type);
            $json = $jsonUtil->setValue($json, "size", $size); 
            $json = $jsonUtil->setValue($json, "mask", $mask);
            $json = $jsonUtil->setValue($json, "id_mandatory", $id_mandatory);
            $json = $jsonUtil->setValue($json, "id_unique", $id_unique);
            $json = $jsonUtil->setValue($json, "id_table_fk", $id_table_fk);
            $json = $jsonUtil->setValue($json, "id_field_fk", $id_field_fk);
            $json = $jsonUtil->setValue($json, "domain", $domain);

            // Return final json
            return $json;
        }    

        public function addDomain($id_system, $key, $value, $domain) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "key", $key);
            $json = $jsonUtil->setValue($json, "value", $value);
            $json = $jsonUtil->setValue($json, "domain", $domain);

            // Return final json
            return $json;
        }

        public function addEvent($id_system, $id_target, $id_table, $id_field, $id_function, $id_event, $code) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_target", $id_target);
            $json = $jsonUtil->setValue($json, "id_table", $id_table);
            $json = $jsonUtil->setValue($json, "id_field", $id_field);
            $json = $jsonUtil->setValue($json, "id_function", $id_function);
            $json = $jsonUtil->setValue($json, "id_event", $id_event);
            $json = $jsonUtil->setValue($json, "code", $code);

            // Return final json
            return $json;
        }    


        public function addFunctionGroup($id_system, $name) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);

            // Return final json
            return $json;
        }

        public function addProfile($id_system, $name) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);

            // Return final json
            return $json;
        }


        public function addProfileTable($id_system, $id_profile, $id_table) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_profile", $id_profile);
            $json = $jsonUtil->setValue($json, "id_table", $id_table);

            // Return final json
            return $json;
        }

        public function addTableFunction($id_system, $id_profile, $id_table, $id_function) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_profile", $id_profile);
            $json = $jsonUtil->setValue($json, "id_table", $id_table);
            $json = $jsonUtil->setValue($json, "id_function", $id_function);

            // Return final json
            return $json;
        }

        public function addUser($id_system, $name, $username, $password) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "username", $username);
            $json = $jsonUtil->setValue($json, "password", $password);

            // Return final json
            return $json;
        }

        public function addUserProfile($id_system, $id_user, $id_profile) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_user", $id_user);
            $json = $jsonUtil->setValue($json, "id_profile", $id_profile);

            // Return final json
            return $json;
        }        

        public function addCode($id_system, $comment, $code) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "comment", $comment);
            $json = $jsonUtil->setValue($json, "code", $code);

            // Return final json
            return $json;
        }

        public function addView($id_system, $name, $sql) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "sql", $sql);

            // Return final json
            return $json;
        }

        public function addFieldSetup($id_system, $id_table, $id_field, $column_size) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_system", $id_system);
            $json = $jsonUtil->setValue($json, "id_group", 1);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_table", $id_table);
            $json = $jsonUtil->setValue($json, "id_field", $id_field);
            $json = $jsonUtil->setValue($json, "column_size", $column_size);

            // Return final json
            return $json;
        }        


        /*
         * End of class   
         */    
    }
?>