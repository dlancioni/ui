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
            
        }

        /*
         * Upload files
         */
        public function authenticate($signId, $username, $password) {

            // General Declaration
            $sql = "";
            $rs = "";
            $filter = "";
            $data = "";
            $msg = "";
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $pathUtil = new PathUtil();
            $message = new Message($this->cn, $this->sqlBuilder);

            try {

                // Validate the username
                $filter = new Filter();
                $filter->addCondition("tb_user", "id_system", "int", "=", $signId);
                $filter->addCondition("tb_user", "login", "text", "=", $username);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A14");
                }

                // Authenticate the password
                if ($msg == "") {
                    $filter = new Filter();
                    $filter->addCondition("tb_user", "id_system", "int", "=", $signId);
                    $filter->addCondition("tb_user", "username", "text", "=", $username);                
                    $filter->addCondition("tb_user", "password", "text", "=", $password);
                    $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                    if (count($data) <= 0) {
                        $msg = $message->getValue("A15");
                    }
                }

                // Move file to destination folder
                if ($msg == "") {
                    $this->authenticated = 1;
                } else {
                    $this->authenticated = 0;
                    $this->error = $msg;
                }

            } catch (Exception $ex) {

                // Keep source and error                
                $this->sqlBuilder->setError("LogicAuth.authenticate()", $ex->getMessage());

                // Rethrow it
                throw $ex;

            } finally {
                // Do nothing
            }
        }

    } // End of class
?>