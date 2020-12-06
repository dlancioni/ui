<?php
    class Base {

        // Current session
        private $systemId = 0;
        private $tableId = 0;
        private $userId = 0;
        private $groupId = 0;

        // Error Handling
        private $error = "";
        private $message = "";
        private $lastId = 0;

        // Other
        private $action = "";

        // Datatypes
        public $TYPE_INT = "int";
        public $TYPE_FLOAT = "float";
        public $TYPE_TEXT = "text";
        public $TYPE_DATE = "date";
        public $TYPE_TIME = "time";
        public $TYPE_BINARY = "binary";

        // HTML control
        public $INPUT_TEXTBOX = 1;
        public $INPUT_DROPDOWN = 2;
        public $INPUT_TEXTAREA = 3;
        public $INPUT_FILE = 4;
        public $INPUT_HIDDEN = 5;
        public $INPUT_PASSWORD = 6;

        // Transactions
        public $TB_MENU = 1;
        public $TB_TABLE = 2;
        public $TB_FIELD = 3;
        public $TB_DOMAIN = 4;
        public $TB_EVENT = 5;
        public $TB_ACTION = 6;
        public $TB_CODE = 7;
        public $TB_VIEW = 8;
        public $TB_VIEW_FIELD = 9;

        // Access Control
        public $TB_PROFILE = 10;
        public $TB_PROFILE_TABLE = 11;
        public $TB_TABLE_ACTION = 12;
        public $TB_USER = 13;
        public $TB_USER_PROFILE = 14;
        public $TB_GROUP = 15;
        public $TB_USER_GROUP = 16;

        // Access Control
        public $TB_CUSTOMER = 17;
        public $TB_ADDRESS = 18;
        public $TB_CONTACT = 19;
        public $TB_ACTIVITY = 20;
        public $TB_RELATIONSHIP = 21;
        public $TB_FILE = 22;

        // Constructor
        function __construct($systemId=0, $tableId=0, $userId=0, $groupId=0) {
            $this->setSystem($systemId);
            $this->setTable($tableId);
            $this->setUser($userId);
            $this->setGroup($groupId);
        }

        // Current session
        public function getSystem() {
            return "'" . trim($this->systemId) . "'";
        }
        public function setSystem($systemId) {
            $this->systemId = $systemId;
        }
        public function getTable() {
            return $this->tableId;
        }
        public function setTable($tableId) {
            $this->tableId = $tableId;
        }
        public function getUser() {
            return $this->userId;
        }
        public function setUser($userId) {
            $this->userId = $userId;
        }
        public function getGroup() {
            return $this->groupId;
        }
        public function setGroup($groupId) {
            $this->groupId = $groupId;
        }

        // Error handling    
        function setError($source, $error) {
            if ($error != "")
                $this->error = $error;
        }
        function getError() {
            return $this->error;
        }

        // Message handling for success or warning
        function setMessage($value) {
            if ($value != "")
            $this->message = $value;
        }
        function getMessage() {
            return $this->message;
        }

        // Last ID
        function setLastId($id) {
            $this->lastId = $id;
        }
        function getLastId() {
            return $this->lastId;
        }

        // Action (new, edit, etc)
        public function getAction() {
            return $this->action;
        }
        public function setEvent($action) {
            $this->action = $action;
        }        

    }
?>