<?php
    class LogicAuth extends Base {

        // Private members
        private $cn = 0;
        public $userId = 0;
        public $userName = "";
        public $profileId = 0;
        public $groupId = 0;
        public $message = "";
        public $authenticated = 0;
        public $menu = "";

        // Constructor
        function __construct($cn="", $sqlBuilder="") {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
            
        }

        /*
         * Authenticate user
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
            $logicMenu = new LogicMenu($this->cn, $this->sqlBuilder);

            try {

                // Validate the username
                $filter = new Filter();
                $filter->addCondition("tb_user", "id_system", $this->TYPE_TEXT, "=", $systemId);
                $filter->addCondition("tb_user", "username", $this->TYPE_TEXT, "=", $username);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A13");
                    throw new Exception($msg);
                } else {
                    $userId = $data[0]["id"];
                }

                // Validate the profile
                $filter = new Filter();
                $filter->addCondition("tb_user_profile", "id_system", $this->TYPE_TEXT, "=", $systemId);
                $filter->addCondition("tb_user_profile", "id_user", $this->TYPE_INT, "=", $userId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER_PROFILE, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A14");
                    throw new Exception($msg);
                } else {
                    $profileId = $data[0]["id_profile"];
                }

                // Validate the group
                $filter = new Filter();
                $filter->addCondition("tb_user_group", "id_system", $this->TYPE_TEXT, "=", $systemId);
                $filter->addCondition("tb_user_group", "id_user", $this->TYPE_INT, "=", $userId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER_GROUP, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A15");
                    throw new Exception($msg);
                } else {
                    $groupId = $data[0]["id_grp"];
                }

                // Validate if profile has transactions
                $filter = new Filter();
                $filter->addCondition("tb_profile_table", "id_system", $this->TYPE_TEXT, "=", $systemId);
                $filter->addCondition("tb_profile_table", "id_profile", $this->TYPE_INT, "=", $profileId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_PROFILE_TABLE, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A16");
                    throw new Exception($msg);
                }

                // Authenticate the password
                $filter = new Filter();
                $filter->addCondition("tb_user", "id_system", $this->TYPE_TEXT, "=", $systemId);
                $filter->addCondition("tb_user", "username", $this->TYPE_TEXT, "=", $username);
                $filter->addCondition("tb_user", "password", $this->TYPE_TEXT, "=", $password);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("A17");
                    throw new Exception($msg);
                }

                // Create application menu based on user profile
                $logicMenu->createMenu($systemId, $userId);

                // Authenticate successfuly                
                $this->authenticated = 1;
                $this->userId = $userId;
                $this->userName = $username;               
                $this->profileId = $profileId;
                $this->groupId = $groupId;
                $this->message = $message->getValue("A18");
                $this->menu = $logicMenu->html;

            } catch (Exception $ex) {

                // Fail to authenticate     
                $this->sqlBuilder->setError("LogicAuth.authenticate()", $ex->getMessage());
                $this->userId = 0;
                $this->userName = "";
                $this->authenticated = 0;
                $this->profileId = 0;
                $this->groupId = 0;
                $this->message = $ex->getMessage();
                $this->menu = "";
            }
        }

        /*
         * Forget password
         */
        public function retrieveCredential($systemId, $email) {

            // General Declaration
            $msg = "";
            $userId = 0;
            $username = "joao";
            $password = "";
            $subject = "";
            $body = "";
            $db = new Db();
            $mail = new Mail();
            $stringUtil = new StringUtil();
            $message = new Message();

            try {

                // Get connection (no schema)
                $cn = $db->getConnection($systemId);

                // Validate email
                if (!$mail->validateEmail($email)) {
                    $msg = $message->getValue("A19");
                    $msg = str_replace("%", $email, $msg);
                    throw new Exception($msg);
                }

                // Retrieve credentials
                $sql = "";
                $sql .= "select" . $stringUtil->lb();
                $sql .= "field->>'username' as username," . $stringUtil->lb();
                $sql .= "field->>'password' as password" . $stringUtil->lb();
                $sql .= "from S20201.tb_user" . $stringUtil->lb();
                $sql .= "where field->>'id_system' = '$systemId'" . $stringUtil->lb();
                $sql .= "and field->>'username' = '$username'" . $stringUtil->lb();
                $rs = pg_query($cn, $sql);

                while ($row = pg_fetch_row($rs)) {
                    $username = $row[0];
                    $password =  $row[1];
                }

                // Prepare mail body
                $subject = "Forms [Recuperar senha]";
                $body = "";
                $body .= "Cód. Acesso: " . $systemId . $stringUtil->lb();
                $body .= "Usuário: " . $username . $stringUtil->lb();
                $body .= "Senha: " . $password . $stringUtil->lb();                

                // Send mail
                $mail->send($email, $subject, $body);

                // Close connection
                if ($cn) {
                    pg_close($cn); 
                }               

            } catch (Exception $ex) {

                $this->sqlBuilder->setError("LogicAuth.forgetPassword()", $ex->getMessage());

                // Close connection
                if ($cn) {
                    pg_close($cn); 
                }
            }
        }

        /*
         * Register new user
         */
        public function register($name, $email) {

            // General Declaration
            $id = 0;
            $rs = "";
            $cn = "";
            $sql = "";            
            $logicSetup = "";
            $systemId = "";
            $affectedRows = 0;
            $expireDate = "20201231";

            $db = new Db();
            $jsonUtil = new JsonUtil();


            try {

                // Get connection (no schema)
                $cn = $db->getConnection("home");

                // Start transaction
                pg_query($cn, "begin");

                // Validate the system id
                $sql = "";
                $sql .= " select";
                $sql .= " email";
                $sql .= " from home.tb_client";
                $sql .= " where email = " . "'" . trim($email) . "'";
                $rs = pg_query($cn, $sql);
                if (pg_fetch_row($rs)) {
                    throw new Exception("Email já cadastrado");
                }

                // Insert new client
                $sql = "insert into home.tb_client (name, email, expire_date, id_system) values ('$name', '$email', '$expireDate', '') returning id";
                $rs = pg_query($cn, $sql);
                if (!$rs) {
                    throw new Exception(pg_last_error($cn));
                }

                // Keep rows affected
                $affectedRows = pg_affected_rows($rs);

                // Get inserted ID
                while ($row = pg_fetch_array($rs)) {
                    $id = $row['id'];
                }

                // Insert new client
                $systemId = "S" . date("Y") . $id;
                $sql = "update home.tb_client set id_system = '$systemId' where id = $id";
                $rs = pg_query($cn, $sql);

                // Keep instance of SqlBuilder for current session
                $sqlBuilder = new SqlBuilder($systemId, 0, 0, 0);
                $logicSetup = new LogicSetup($cn, $sqlBuilder);
                $logicSetup->setup($systemId);

                // Commit transaction
                pg_query($cn, "commit");

                // Close connection
                if ($cn) {
                    pg_close($cn); 
                }

                // Send credentials to new user
                $this->retrieveCredential($systemId, $email);

            } catch (Exception $ex) {

                // Rollback transaction
                pg_query($cn, "rollback");                

                // Close connection
                if ($cn) {
                    pg_close($cn); 
                }

                throw $ex;
            }
        }


    } // End of class
?>