<?php
    class Base {
        // Current session
        private $systemId = 0;
        private $tableId = 0;
        private $userId = 0;

        // Error Handling
        private $error = "";
        private $message = "";
        private $lastId = 0;

        // Other
        private $event = 0;

        // Constructor
        function __construct($systemId, $tableId, $userId) {
            $this->setSystem($systemId);
            $this->setTable($tableId);
            $this->setUser($userId);
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

        // Error handling    
        function setError($source, $error) {
            if ($error != "")
            $this->error = $source . ": " . $error;
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