<?php
    class Db extends Base {

        /* 
         * Constructor mandatory as extends base
         */        
        function __construct() {
        }

        /* 
         * Get postgres connection
         */
        public function getConnection() {

            // General Declaration
            $error = "";
            $cn = "";

            try {
                // Try to connect
                $cn = pg_connect("postgres://qqbzxiqr:EmiJvVhFJGxDEKJoV6yK9A6o2G5pkmR9@tuffi.db.elephantsql.com:5432/qqbzxiqr");               

                // Handle errors
                $error = pg_last_error($cn);
                if ($error != "") {
                    die("Connection failed: " . $error);
                }

            } catch (Exception $ex) {
                $this->setError("Db.getConnection()", $this->getConnection()->error);
            }
            // Return connection
            return $cn;
        }

        /* 
         * Query and return resultset
         */
        public function query($cn, $sql) {

            // General Declaration
            $resultset = "";

            // Execute query            
            try {
                $resultset = pg_query($cn, $sql);
                $this->setError("", "");
            } catch (exception $ex) {                
                $resultset = "";
                $this->setError("db.query()", pg_last_error($cn));
            }

            // Return data
            return $resultset;
        }

        /* 
         * Query and return json
         */
        public function queryJson($cn, $sql) {

            // General Declaration
            $rs = "";
            $json = "";

            try {

                // Transform results to json
                $sql = "select json_agg(t) from (" . $sql . ") t";

                // Execute query
                $rs = pg_query($cn, $sql);
                $this->setError("", "");                
                while ($row = pg_fetch_row($rs)) {
                    $json = $row[0];
                    break;
                }
            } catch (exception $ex) {                
                $this->setError("db.queryJson()", pg_last_error($cn));
            }

            // Handle empty json
            if (!$json) {
                $json = "[]";
            }

            // Return rs as json
            return json_decode($json, true);
        }        

        /* 
         * Persist data
         */        
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
                    throw new Exception(pg_last_error($cn));
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