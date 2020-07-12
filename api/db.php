<?php
    class Db extends Base {

        function __construct() {
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
            return $json;
        }        

        public function persist() {

            // General Declaration
            $db = "";
            $conn = "";

            try {
                // Get connection
                $conn = $this->getConnection();
                $this->setError("", "");
    
                // Open transaction
                pg_query($conn, "begin");
        
                // Execute statement            
                $result = pg_query($conn, "insert into tb (ds) values ('abcde') returning id;");
                if (!$result) {
                    throw new Exception(pg_last_error($conn));
                }

                // Get inserted ID
                while ($row = pg_fetch_array($result)) {
                    $this->setLastId($row['id']);
                }               
        
                // Commit transaction
                pg_query($conn, "commit");        
    
            } catch (Exception $ex) {
    
                // Undo transaction    
                pg_query($conn, "rollback");

                // Keep last error
                $this->setError("Persist.Insert()", $ex->getMessage());
    
            } finally {
                pg_close($conn); 
            }
        }        

    } // End of class
?>