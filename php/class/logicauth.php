<?php
    class LogicAuth extends Base {

        // Private members
        private $cn = 0;
        public $userId = 0;
        public $groupId = 0;
        public $authenticated = 0; 
        public $error = ""; 

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
            $this->message = new Message($this->cn, $this->sqlBuilder);
        }

        /*
         * Upload files
         */
        public function authenticate($signId, $username, $password) {

            // General Declaration
            $sql = "";
            $rs = "";
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $pathUtil = new PathUtil();

            try {

                // Move file to destination folder
                if ($this->authenticated == 0) {
                    $this->authenticated = 1;
                }

            } catch (Exception $ex) {

                // Keep source and error                
                $this->sqlBuilder->setError("Upload.uploadFiles()", $ex->getMessage());

                // Rethrow it
                throw $ex;

            } finally {
                // Do nothing
            }
        }

    } // End of class
?>