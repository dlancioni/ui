<?php
    class LogicAuth extends Base {

        // Private members
        private $cn = 0;
        public $userId = 0;
        public $profileId = 0;
        public $groupId = 0;
        public $message = "";
        public $authenticated = 0;

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
            
        }

        /*
         * Upload files
         */
        public function authenticate($systemId, $username, $password) {

            // General Declaration
            $sql = "";
            $rs = "";
            $msg = "";
            $data = "";
            $filter = "";
            $userId = 0;
            $profileId = 0;
            $groupId = 0;
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $pathUtil = new PathUtil();
            $message = new Message($this->cn, $this->sqlBuilder);

            try {

                // Validate the username
                $filter = new Filter();
                $filter->addCondition("tb_user", "id_system", "int", "=", $systemId);
                $filter->addCondition("tb_user", "username", "text", "=", $username);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A13");
                    throw new Exception($msg);
                } else {
                    $userId = $data[0]["id"];
                }

                // Validate the profile
                $filter = new Filter();
                $filter->addCondition("tb_user_profile", "id_system", "int", "=", $systemId);
                $filter->addCondition("tb_user_profile", "id_user", "int", "=", $userId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER_PROFILE, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A14");
                    throw new Exception($msg);
                } else {
                    $profileId = $data[0]["id_profile"];
                }

                // Validate the group
                $filter = new Filter();
                $filter->addCondition("tb_user_group", "id_system", "int", "=", $systemId);
                $filter->addCondition("tb_user_group", "id_user", "int", "=", $userId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER_GROUP, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A15");
                    throw new Exception($msg);
                } else {
                    $groupId = $data[0]["id_grp"];
                }

                // Validate if profile has transactions
                $filter = new Filter();
                $filter->addCondition("tb_profile_table", "id_system", "int", "=", $systemId);
                $filter->addCondition("tb_profile_table", "id_profile", "int", "=", $profileId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_PROFILE_TABLE, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A16");
                    throw new Exception($msg);
                }

                // Authenticate the password
                $filter = new Filter();
                $filter->addCondition("tb_user", "id_system", "int", "=", $systemId);
                $filter->addCondition("tb_user", "username", "text", "=", $username);
                $filter->addCondition("tb_user", "password", "text", "=", $password);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A17");
                    throw new Exception($msg);
                }

                // Authenticate successfuly                
                $this->authenticated = 1;
                $this->userId = $userId;
                $this->profileId = $profileId;
                $this->groupId = $groupId;
                $this->message = $message->getValue("A18");

            } catch (Exception $ex) {

                // Fail to authenticate     
                $this->sqlBuilder->setError("LogicAuth.authenticate()", $ex->getMessage());
                $this->userId = 0;
                $this->authenticated = 0;
                $this->profileId = 0;
                $this->groupId = 0;
                $this->message = $ex->getMessage();
            }
        }

    } // End of class
?>