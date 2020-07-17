<?php
    class Db extends Base {

        public $connection = "";

        function __construct() {
            $connection = $this->getConnection();
        }

        public function getConnection() {
            try {
                $connection = pg_connect("postgres://qqbzxiqr:EmiJvVhFJGxDEKJoV6yK9A6o2G5pkmR9@tuffi.db.elephantsql.com:5432/qqbzxiqr");
                $error = pg_last_error($connection);
                if ($error != "") {
                    die("Connection failed: " . $error);
                }
            } catch (Exception $ex) {
                $this->setError("Db.getConnection()", $this->getConnection()->error);
            }
            return $connection;
        }

        public function query($sql) {
            $connection = "";
            $resultset = "";
            try {
                $connection = $this->getConnection();
                $resultset = pg_query($connection, $sql);
                $this->setError("", "");
            } catch (exception $ex) {                
                $resultset = "";
                $this->setError("db.query()", pg_last_error($connection));
            } finally {
                pg_close($connection);
            }
            return $resultset;
        }

        public function queryJson($sql) {
            $connection = "";
            $resultset = "";
            $json = "";
            try {
                error_log($sql);
                $sql = "select json_agg(t) from (" . $sql . ") t";
                $connection = $this->getConnection();
                $resultset = pg_query($connection, $sql);
                while ($row = pg_fetch_row($resultset)) {
                    $json = $row[0];
                    break;
                }
                $this->setError("", "");
            } catch (exception $ex) {                
                $resultset = "";
                $this->setError("db.queryJson()", pg_last_error($connection));
            } finally {
                pg_close($connection);
            }

            if (!$json) {
                $json = "[]";
            }

            return json_decode($json, true);
        }        

        public function persist($cn, $action, $table, $data) {
            
           // General declaration
           $sql = "";
           $rs = "";

            try {

                // Reset values
                $this->setLastId(0);
                $this->setError("", "");

                // Prepare string
                switch ($action) {
                    case "I":
                        $sql = "insert into $table (field) values ('$data') returning id";
                        break;
                }
        
                // Execute statement            
                $rs = pg_query($cn, $sql);
                if (!$rs) {
                    throw new Exception(pg_last_error($connection));
                }

                // Get inserted ID
                while ($row = pg_fetch_array($rs)) {
                    $this->setLastId($row['id']);
                }
    
            } catch (Exception $ex) {

                // Keep last error
                $this->setError("Persist.Insert()", $ex->getMessage());
            }
            
            // Return ID
            return $this->getLastId();
        }        

    } // End of class
?>