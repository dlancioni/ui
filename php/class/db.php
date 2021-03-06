<?php
    class Db extends Base {

        public $environment;

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
            $cn = "";
            $error = "";
            $os = new OS();

            try {

                // Connect to database
                if ($os->getOS() == $os->WINDOWS) {
                    $cn = pg_connect("postgres://forms_dev:d4a1v21i@forms_dev.postgresql.dbaas.com.br/forms_dev");
                    $this->environment = "DEV_";
                } else {
                    $cn = pg_connect("postgres://forms_prod:d4a1v21i@forms_prod.postgresql.dbaas.com.br/forms_prod");
                    $this->environment = "";
                }

                // Handle errors
                $error = pg_last_error($cn);
                if ($error != "") {
                    die("Connection failed: " . $error);
                }

                if (trim($systemId) != "") {
                    pg_query($cn, "set search_path to $systemId");
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
                $this->setError("db.queryJson()", $ex->getMessage());
                throw $ex;
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