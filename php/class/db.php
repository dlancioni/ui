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
        public function persist($cn, $tableName, $record) {
            
           // General declaration
           $key = "";
           $sql = "";
           $rs = "";
           $message = "";
           $affectedRows = "";
           $event = $this->getEvent();
           $jsonUtil = new jsonUtil();

            // Handle invalid chars
            $record = str_replace("'", "''", $record);

            // Make sure id_system is set
            $record = $jsonUtil->setValue($record, "id_system", $this->getSystem());
            $record = $jsonUtil->setValue($record, "id_group", $this->getGroup());

            // Prepare condition for update and delete
            $key .= " where " . $jsonUtil->condition($tableName, "id", "int", "=", $this->getLastId());                        
            if ($tableName != "tb_system") {
                $key .= " and " . $jsonUtil->condition($tableName, "id_system", "int", "=", $this->getSystem());
            }

            try {

                // Prepare string
                switch ($event) {

                    case "New":
                        $sql = "insert into $tableName (field) values ('$record') returning id";
                        $message = "Record successfuly created";
                        break;

                    case "Edit":
                        $sql .= " update $tableName set field = '$record' " . $key;
                        $message = "Record successfuly updated";
                        break;

                    case "Delete":
                        $sql .= " delete from $tableName " . $key;
                        $message = "Record successfuly deleted";                        
                        break;                        
                }

                // Execute statement            
                $rs = pg_query($cn, $sql);
                if (!$rs) {
                    throw new Exception(pg_last_error($cn));
                }

                // Keep rows affected
                $affectedRows = pg_affected_rows($rs);                

                // Get inserted ID
                while ($row = pg_fetch_array($rs)) {
                    $this->setLastId($row['id']);
                }

                // Success
                $this->setError("", "");
                $this->setMessage($message);
    
            } catch (Exception $ex) {

                // Keep last error
                $this->setMessage("");
                $this->setError("Db.Persist()", $ex->getMessage());

            } finally {
                // Do nothing
            }
            
            // Return ID
            return $this->getLastId();
        }        

    } // End of class
?>