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
            $viewId = 0;
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $pathUtil = new PathUtil();
            $message = new Message($this->cn);
            $logicMenu = new LogicMenu($this->cn);

            try {

               /*
                * Validate the system id
                */
                $sql = "";
                $sql .= " select schema_name from information_schema.schemata";
                $sql .= " where upper(schema_name) = " . "'" . trim(strtoupper($systemId)) . "'";
                $rs = pg_query($this->cn, $sql);
                if (!pg_fetch_row($rs)) {
                    throw new Exception("Cód. Assinante não encontrado");
                }

                // Validate the username
                $filter = new Filter();
                $filter->addCondition("tb_user", "username", $this->TYPE_TEXT, "=", $username);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $viewId, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("M13");
                    throw new Exception($msg);
                } else {
                    $userId = $data[0]["id"];
                }

                // Validate the profile
                $filter = new Filter();
                $filter->addCondition("tb_user_profile", "id_user", $this->TYPE_INT, "=", $userId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER_PROFILE, $viewId, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("M14");
                    throw new Exception($msg);
                } else {
                    $profileId = $data[0]["id_profile"];
                }

                // Validate the group
                $filter = new Filter();
                $filter->addCondition("tb_user_group", "id_user", $this->TYPE_INT, "=", $userId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER_GROUP, $viewId, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("M15");
                    throw new Exception($msg);
                } else {
                    $groupId = $data[0]["id_grp"];
                }

                // Validate if profile has transactions
                $filter = new Filter();
                $filter->addCondition("tb_profile_table", "id_profile", $this->TYPE_INT, "=", $profileId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_PROFILE_TABLE, $viewId, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("M16");
                    throw new Exception($msg);
                }

                // Authenticate the password
                $filter = new Filter();
                $filter->addCondition("tb_user", "username", $this->TYPE_TEXT, "=", $username);
                $filter->addCondition("tb_user", "password", $this->TYPE_TEXT, "=", $password);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $viewId, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("M17");
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
                $this->message = $message->getValue("M18");
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
            $mail = new Mail();
            $stringUtil = new StringUtil();
            $message = new Message();
            $lb = $stringUtil->lb();

            try {

                // Get connection (no schema)
                $cn = $this->cn;
                $this->setError("", "");

                // Validate email
                if (!$mail->validateEmail($email)) {
                    $msg .= "Por favor informe um e-mail válido";
                    throw new Exception($msg);
                }

                // Retrieve credentials
                if (trim($systemId) == "") {                    
                    $sql = "";
                    $sql .= " select" . $lb;
                    $sql .= " id_system" . $lb;
                    $sql .= " from home.tb_client" . $lb;
                    $sql .= " where email = '$email'" . $lb;
                    $rs = pg_query($cn, $sql);
                    while ($row = pg_fetch_row($rs)) {
                        $systemId = $row[0];
                        break;
                    }
                }

                // Retrieve credentials
                $sql = "";
                $sql .= "select" . $stringUtil->lb();
                $sql .= "field->>'username' as username," . $stringUtil->lb();
                $sql .= "field->>'password' as password" . $stringUtil->lb();
                $sql .= "from s20201.tb_user" . $stringUtil->lb();
                $sql .= "where field->>'username' = '$username'" . $stringUtil->lb();
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

            } catch (Exception $ex) {
                $this->setError("LogicAuth.retrieveCredential()", $ex->getMessage());
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
            $msg = "";
            $date = "";

            $systemId = "";
            $setupCore = "";
            $setupEntity = "";
            $affectedRows = 0;
            $expireDate = "";
            $mail = new Mail();
            $jsonUtil = new JsonUtil();


            try {

                // Get connection (no schema)
                $cn = $this->cn;

                // Start transaction
                pg_query($cn, "begin");

                // Validate name
                if (trim($name) == "") {
                    $msg = "O campo nome é obrigatório";
                    throw new Exception($msg);
                }

                // Validate email
                if (!$mail->validateEmail($email)) {
                    $msg .= "Por favor informe um e-mail válido";
                    throw new Exception($msg);
                }

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

                // Calculate expire date
                $date = new DateTime();
                $date->add(new DateInterval('P3M'));
                $expireDate = $date->format('Y-m-d');

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

                $setupCore = new SetupCore($cn, $sqlBuilder);
                $setupCore->setup($systemId);

                $setupEntity = new SetupEntity($cn, $sqlBuilder);
                $setupEntity->setup($systemId);

                // Commit transaction
                pg_query($cn, "commit");

                // Send credentials to new user
                $this->retrieveCredential($systemId, $email);

            } catch (Exception $ex) {

                // Rollback transaction
                pg_query($cn, "rollback");                

                // Keep error message
                $this->setError("LogicAuth.retrieveCredential()", $ex->getMessage());                

            }
        }

        /*
         * Change password
         */
        public function changePassword($userId, $current, $new, $confirm) {

            // General Declaration
            $rs = "";
            $sql = "";
            $msg = "";
            $data = "";
            $filter = "";
            $viewId = 0;
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $pathUtil = new PathUtil();
            $message = new Message($this->cn);

            try {

                // Validate mandatory fields
                if ($userId == 0) {
                    $msg = $message->getValue("M1");
                    $msg = str_replace("%", "usuário", $msg);
                    throw new Exception($msg);
                }
                if (trim($current) == "") {
                    $msg = $message->getValue("M1");
                    $msg = str_replace("%", "senha atual", $msg);
                    throw new Exception($msg);
                }
                if (trim($new) == "") {
                    $msg = $message->getValue("M1");
                    $msg = str_replace("%", "nova senha", $msg);
                    throw new Exception($msg);
                }
                if (trim($confirm) == "") {
                    $msg = $message->getValue("M1");
                    $msg = str_replace("%", "confirmar nova senha", $msg);
                    throw new Exception($msg);
                }

                // Specific rules
                if (trim($new) != trim($confirm)) {
                    $msg = $message->getValue("M27");
                    throw new Exception($msg);
                }

                // Validate user id
                $filter = new Filter();
                $filter->addCondition("tb_user", "id", $this->TYPE_TEXT, "=", $userId);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $viewId, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("M13");
                    throw new Exception($msg);
                }

                // Validate current password
                $filter = new Filter();
                $filter->addCondition("tb_user", "id", $this->TYPE_TEXT, "=", $userId);
                $filter->addCondition("tb_user", "password", $this->TYPE_TEXT, "=", $current);
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->sqlBuilder->TB_USER, $viewId, $filter->create(), $this->sqlBuilder->QUERY_NO_JOIN);
                if (count($data) <= 0) {
                    $msg = $message->getValue("M28");
                    throw new Exception($msg);
                }

                // Success
                $this->message = $message->getValue("M26");;

            } catch (Exception $ex) {

                // Fail
                $this->message = $ex->getMessage();
            }
        }



    } // End of class
?>