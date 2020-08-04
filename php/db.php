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
                $this->setError("db.getConnection()", $this->getConnection()->error);
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
        public function persist($cn, $tableName, $data) {
            
           // General declaration
           $sql = "";
           $rs = "";
           $event = $this->getEvent();
           $jsonUtil = new jsonUtil();
           $message = "";

            // Reset values
            $this->setError("", "");
            $this->setMessage("");

            // Handle invalid chars
            $data = str_replace("'", "''", $data);

            // Make sure id_system is set
            $data = $jsonUtil->setValue($data, "id_system", $this->getSystem());

            try {

                // Prepare string
                switch (strtoupper($event)) {
                    case "NEW":
                        $sql = "insert into $tableName (field) values ('$data') returning id";
                        $message = "Record successfuly created";
                        break;
                    case "EDIT":
                        $sql .= " update $tableName set field = '$data'";
                        $sql .= " where " . $jsonUtil->condition($tableName, "id", "int", "=", $this->getLastId());
                        if ($tableName != "tb_system") {
                            $sql .= " and " . $jsonUtil->condition($tableName, "id_system", "int", "=", $this->getSystem());
                        }
                        $message = "Record successfuly updated";
                        break;
                    case "DELETE":
                        $sql .= " delete from $tableName";
                        $sql .= " where " . $jsonUtil->condition($tableName, "id", "int", "=", $this->getLastId());                        
                        if ($tableName != "tb_system") {
                            $sql .= " and " . $jsonUtil->condition($tableName, "id_system", "int", "=", $this->getSystem());
                        }
                        $message = "Record successfuly deleted";                        
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

                // Stamp the ID
                $message .= " [" . $this->getLastId() . "]";
                $this->setMessage($message);
    
            } catch (Exception $ex) {

                // Keep last error
                $this->setError("db.Insert()", $ex->getMessage());
            }
            
            // Return ID
            return $this->getLastId();
        }        

    } // End of class
?>