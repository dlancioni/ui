<?php
    class Model extends Base {

        // Private members
        private $cn = 0;
        public $systemId;
        public $groupId;

        // Constructor
        function __construct($id_group) {
            $this->groupId = $id_group;
        }

        public function addSystem($name, $expire_date, $price) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "expire_date", $expire_date);
            $json = $jsonUtil->setValue($json, "price", $price);

            // Return final json
            return $json;
        }

        public function addMenu($name, $id_parent) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "id_parent", $id_parent);

            // Return final json
            return $json;
        }

        public function addModule($name, $title, $id_type, $id_style, $id_menu) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "title", $title);
            $json = $jsonUtil->setValue($json, "id_type", $id_type);
            $json = $jsonUtil->setValue($json, "id_style", $id_style);
            $json = $jsonUtil->setValue($json, "id_menu", $id_menu);
            
            // Return final json
            return $json;
        }

        public function addField($id_module, $label, $name, $id_type, $size, $mask, $id_mandatory, $id_unique, $id_module_fk, $id_field_fk, $domain, $default_value, $id_control, $ordenation) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record
            $json = $jsonUtil->setValue($json, "id_module", $id_module);
            $json = $jsonUtil->setValue($json, "label", $label);
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "id_type", $id_type);
            $json = $jsonUtil->setValue($json, "size", $size); 
            $json = $jsonUtil->setValue($json, "mask", $mask);
            $json = $jsonUtil->setValue($json, "id_mandatory", $id_mandatory);
            $json = $jsonUtil->setValue($json, "id_unique", $id_unique);
            $json = $jsonUtil->setValue($json, "id_module_fk", $id_module_fk);
            $json = $jsonUtil->setValue($json, "id_field_fk", $id_field_fk);
            $json = $jsonUtil->setValue($json, "domain", $domain);
            $json = $jsonUtil->setValue($json, "default_value", $default_value);
            $json = $jsonUtil->setValue($json, "id_control", $id_control);
            $json = $jsonUtil->setValue($json, "ordenation", $ordenation);

            // Return final json
            return $json;
        }    

        public function addDomain($groupId, $key, $value, $domain) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "key", $key);
            $json = $jsonUtil->setValue($json, "value", $value);
            $json = $jsonUtil->setValue($json, "domain", $domain);

            // Return final json
            return $json;
        }

        public function addEvent($id_target, $name, $id_event, $id_module, $id_field, $code) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_target", $id_target);
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "id_event", $id_event);
            $json = $jsonUtil->setValue($json, "id_module", $id_module);
            $json = $jsonUtil->setValue($json, "id_field", $id_field);            
            $json = $jsonUtil->setValue($json, "code", $code);

            // Return final json
            return $json;
        }    


        public function addFunction($name) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);

            // Return final json
            return $json;
        }

        public function addGroup($name) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);

            // Return final json
            return $json;
        }        

        public function addProfile($name) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);

            // Return final json
            return $json;
        }


        public function addProfileField($id_profile, $id_module, $id_field) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_profile", $id_profile);
            $json = $jsonUtil->setValue($json, "id_module", $id_module);
            $json = $jsonUtil->setValue($json, "id_field", $id_field);

            // Return final json
            return $json;
        }

        public function addModuleEvent($id_profile, $id_module, $id_event) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_profile", $id_profile);
            $json = $jsonUtil->setValue($json, "id_module", $id_module);
            $json = $jsonUtil->setValue($json, "id_event", $id_event);

            // Return final json
            return $json;
        }

        public function addUser($groupId, $name, $email, $username, $password) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "email", $email);
            $json = $jsonUtil->setValue($json, "username", $username);
            $json = $jsonUtil->setValue($json, "password", $password);

            // Return final json
            return $json;
        }

        public function addUserProfile($groupId, $id_user, $id_profile) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_user", $id_user);
            $json = $jsonUtil->setValue($json, "id_profile", $id_profile);

            // Return final json
            return $json;
        }

        public function addUserGroup($groupId, $id_user, $id_group) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $groupId);
            
            // Create record
            $json = $jsonUtil->setValue($json, "id_user", $id_user);
            $json = $jsonUtil->setValue($json, "id_grp", $id_group);

            // Return final json
            return $json;
        }

        public function addCode($comment, $code) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "comment", $comment);
            $json = $jsonUtil->setValue($json, "code", $code);

            // Return final json
            return $json;
        }

        public function addView($name, $sql) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "name", $name);
            $json = $jsonUtil->setValue($json, "sql", $sql);

            // Return final json
            return $json;
        }

        public function addFieldSetup($id_module, $id_field, $column_size) {

            // General Declaration
            $json = "";
            $jsonUtil = new JsonUtil();

            // Create key
            $json = $jsonUtil->setValue($json, "id_group", $this->groupId);

            // Create record        
            $json = $jsonUtil->setValue($json, "id_module", $id_module);
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