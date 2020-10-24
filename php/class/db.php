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
        public function getConnection($systemId) {

            // General Declaration
            $error = "";
            $cn = "";

            /// ftp form12/David@Locaweb1

            try {

                // Elephant SQL
                //$cn = pg_connect("postgres://qqbzxiqr:EmiJvVhFJGxDEKJoV6yK9A6o2G5pkmR9@tuffi.db.elephantsql.com:5432/qqbzxiqr");

                // Locaweb
                $cn = pg_connect("postgres://form1db:d4a1v21i@form1db.postgresql.dbaas.com.br:5432/form1db");
                
                // Handle errors
                $error = pg_last_error($cn);
                if ($error != "") {
                    die("Connection failed: " . $error);
                }

                if (trim($systemId) != "") {
                    pg_query($cn, "set search_path to system_$systemId");
                }

            } catch (Exception $ex) {
                $this->setError("db.getConnection()", $cn->error);
            }
            // Return connection
            return $cn;
        }

        /* 
         * Query and return resultset
         */
        public function executeQuery($cn, $sql) {

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

    } // End of class
?>