<?php
    class Base {

        // Other
        private $action = "";

        // Current session
        private $systemId = 0;
        private $moduleId = 0;
        private $userId = 0;
        private $groupId = 0;

        // Error Handling
        private $error = "";
        private $message = "";
        private $lastId = 0;
        private $viewId = 0;

        // Tabbed control
        public $showTitle = true;
        public $showAction = true;
        public $showPaging = true;
        public $pageTitle = "";

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
        public $TB_MODULE = 2;
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
        public $TB_MODULE_EVENT = 12;
        public $TB_USER = 13;
        public $TB_USER_PROFILE = 14;
        public $TB_GROUP = 15;
        public $TB_USER_GROUP = 16;
        public $TB_UPD_PWD = 17;

        // Access Control
        public $TB_CUSTOMER = 17;
        public $TB_ADDRESS = 18;
        public $TB_CONTACT = 19;
        public $TB_ACTIVITY = 20;
        public $TB_RELATIONSHIP = 21;
        public $TB_FILE = 22;

        // Profiles
        public $PROFILE_SYSTEM = 1;
        public $PROFILE_ADMIN = 2;
        public $PROFILE_USER = 3;

        // Module type
        public $TYPE_SYSTEM = 1;
        public $TYPE_USER = 2;

        // Module type
        public $STYLE_TABLE = 1;
        public $STYLE_FORM = 2;        

        // Aggregation
        public $SELECTION = 1;
        public $COUNT = 2;
        public $SUM = 3;
        public $MAX = 4;
        public $MIN = 5;
        public $AVG = 6;
        public $CONDITION = 7;
        public $ORDERING_ASC = 8;
        public $ORDERING_DESC = 9;

        // Events
        public $EVENT_CLICK = 2;
        public $EVENT_CHANGE = 3;

        // Actions (see event.js must have equivalent item)
        public $ACTION_NONE = 0;
        public $ACTION_NEW = 1;
        public $ACTION_EDIT = 2;
        public $ACTION_DELETE = 3;
        public $ACTION_DETAIL = 4;
        public $ACTION_CONFIRM = 5;
        public $ACTION_FILTER = 6;
        public $ACTION_CLEAR = 7;
        public $ACTION_BACK = 8;
        public $ACTION_TEST = 9;

        // View type
        public $REPORT = 1;
        public $CHART_LINE = 2;
        public $CHART_COLUMN = 3;
        public $CHART_AREA = 4;
        public $CHART_PIZZA = 5;

        // Constructor
        function __construct($systemId=0, $moduleId=0, $userId=0, $groupId=0) {
            $this->setSystem($systemId);
            $this->setModule($moduleId);
            $this->setUser($userId);
            $this->setGroup($groupId);
        }

        // Current session
        public function getSystem() {
            return trim($this->systemId);
        }
        public function setSystem($systemId) {
            $this->systemId = $systemId;
        }
        public function getModule() {
            return $this->moduleId;
        }
        public function setModule($moduleId) {
            $this->moduleId = $moduleId;
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

        // view ID
        function setView($id) {
            $this->viewId = $id;
        }
        function getView() {
            return $this->viewId;
        }

        // Action (new, edit, etc)
        public function getAction() {
            return $this->action;
        }
        public function setAction($action) {
            $this->action = $action;
        }        

    }
?>