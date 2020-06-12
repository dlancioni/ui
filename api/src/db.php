<?php
    class Db {

        private $error;
        function __construct() {
        }

        // Error handling    
        function setError($source, $error) {
            if ($error != "")
            $this->error = $source . ": " . $error;
        }
        function getError() {
            return $this->error;
        }

        public function getConnection() {
            $connection = "";
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
                $sql = "select json_agg(t) from (" . $sql . ") t";
                $connection = $this->getConnection();
                $resultset = pg_query($connection, $sql);
                $this->setError("", "");
            } catch (exception $ex) {                
                $resultset = "";
                $this->setError("db.Query()", pg_last_error($connection));
            } finally {
                pg_close($connection);
            }
            return $resultset;
        }

    } // End of class
?>