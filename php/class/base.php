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
        private $event = 0;

        // Datatypes
        public $TYPE_INT = 1;
        public $TYPE_FLOAT = 2;
        public $TYPE_TEXT = 3;
        public $TYPE_DATE = 4;
        public $TYPE_TIME = 5;
        public $TYPE_TEXTAREA = 6;
        public $TYPE_FILE = 7;
        public $TYPE_PASSWORD = 8;

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
        public $TB_FIELD_ATTRIBUTE = 10;

        // Access Control
        public $TB_PROFILE = 11;
        public $TB_PROFILE_TABLE = 12;
        public $TB_TABLE_FUNCTION = 13;
        public $TB_USER = 14;
        public $TB_USER_PROFILE = 15;
        public $TB_GROUP = 16;
        public $TB_USER_GROUP = 17;

        // Access Control
        public $TB_CUSTOMER = 18;
        public $TB_ADDRESS = 19;

        // Constructor
        function __construct($systemId, $tableId, $userId, $groupId) {
            $this->setSystem($systemId);
            $this->setTable($tableId);
            $this->setUser($userId);
            $this->setGroup($groupId);
        }

        // Current session
        public function getSystem() {
            return $this->systemId;
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

        // Event
        public function getEvent() {
            return $this->event;
        }
        public function setEvent($event) {
            $this->event = $event;
        }        

    }
?>