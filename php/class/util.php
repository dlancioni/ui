<?php

    class LogUtil {

        public function log($fileName, $contents) {
            $file = fopen("$fileName.txt", "w") or die("Unable to open file!");
            fwrite($file, $contents);
            fclose($file);            
        }
    }

    class PathUtil {

        /*
         * Get virtual file path
         */
        public function getVirtualPath() {

            $path = "";

            try {

                // Get slash position
                $pos = strpos(realpath('.'), "\\");

                if ($pos > 0) {
                    $path = "/ui/php/files/"; // Windows
                } else {
                    $path = "/php/files/"; // Linux
                }

            } catch (Exception $ex) {
                throw $ex;
            }

            return $path;
        }

        /*
         * Get upload path for windows or linux
         */
        public function getUploadPath() {

            $path = "";
            $pos = 0;

            try {

                // Get slash position
                $pos = strpos(realpath('.'), "\\");

                if ($pos > 0) {
                    $path = realpath('.') . "\\files\\"; // Windows
                } else {
                    $path = realpath('.') . "/files/"; // Linux
                }

            } catch (Exception $ex) {
                throw $ex;
            }

            return $path;
        }
    }


    class NumberUtil {
       /*
        * Make number in english (remove , or .)
        */        
        function valueOf($value) {

            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);

            if (trim($value) == "") {
                $value = "0.00";
            }

            return $value;
        }
    }

    class StringUtil {
        /*
         * Put value between single quote
         */        
        function sqt($value) {
            return "'" . trim($value) . "'";
        }

        /*
         * Put value between double quote
         */        
        function dqt($value) {
            return "\"" . trim($value) . "\"";
        }

        /*
         * Line break
         */
        function lb() {
            return "\n";
        }

        /*
         * Replace ' by '' as per database requirement
         */
        function RemoveSpecialChar($record) {
            return str_replace("'", "''", $record);
        }        

    }
    
    class JsonUtil extends StringUtil {

        /*
         * TableDef to json
         */
        public function getJson($tableDef) {
            $json = "";
            $value = "";
            foreach ($tableDef as $item) {
                switch ($item["field_type"]) {
                    case "int":
                    case "float":
                        $value = 0;
                        break;
                    default:    
                        $value = "";
                }

                $json = $this->setValue($json, $item["field_name"], $value);
            }
            return $json;
        }

        /*
         * Set value in specific tag
         */
        public function setValue($json, $field, $value) {
            $json = json_decode($json, true);

            if (is_numeric($value)) {
                if (is_int($value)) {
                    $json[$field] = intval($value);
                } else {
                    $json[$field] = floatval($value);
                }
            } else {
                $json[$field] = strval($value);
            }

            $json = json_encode($json);
            return $json;
        }

        /*
         * Get value of specific tag
         */
        public function getValue($json, $field, $toUpperCase=false) {

            $value = "";
            $json = json_decode($json, true);

            if (isset($json[$field])) {
                $value = trim($json[$field]);
            }

            if ($toUpperCase) {
                $value = strtoupper($value);
            }

            return $value;
        }

        /*
         * Plain field
         */
        public function field($table, $field, $type, $mask="") {
            $output = "";

            if (trim($field) == "id") {
                $output = $table . "." . $field;
            } else {

                if ($type == "date") {
                    $output = "to_date(" . $table . ".field" . '->>' . $this->sqt($field) . ", " . $this->sqt($mask) . ")";
                } else {
                    $output = "(" . $table . ".field" . '->>' . $this->sqt($field) . ")::" . $type;
                }
            }

            return $output;
        }

        /*
         * Select field
         */
        public function select($table, $field, $type, $alias="") {

            $output = "";
            
            // Avoid conversion on select field
            if ($type == "date" || $type == "binary") {
                $type = "text";
            }

            $output = $this->field($table, $field, $type) . " as " . (trim($alias) == "" ? $field : $alias);
            return $output;
        }

        /*
         * Condition (and clause)
         */
        public function condition($table, $field, $type, $operator, $value, $mask="") {
            
            // General Declaration
            $condition = "";
            $numberUtil = new NumberUtil();

            // Base field            
            $condition .= $this->field($table, $field, $type, $mask);

            // Operator
            if (trim($operator) == "") {
                $operator = "=";
            } else {
                $operator = trim($operator);
            }
            $condition .= " " . $operator . " ";
            
            // Handle quotes
            switch ($type) {
                case "int":
                case "float":
                    $value = $numberUtil->valueOf($value);
                    break;
                case "date":
                    $value = $this->sqt($value);
                    break;
                default:
                    // Avoid duplication
                    $value = str_replace("'", "", $value);
                    $value = $this->sqt($value);
            }

            // Set value
            if ($type == "date") {
                $condition .= "to_date(" . $value . ", " . $this->sqt($mask) . ")";
            } else {
                $condition .= $value;
            }
            // Return condition
            return $condition;
        }

        /*
         * Join (inner and left)
         */
        public function join($table1, $field1, $table2, $domain="") {
            // General declaration
            $join = "";
            $alias = "";
            if (trim($domain) == "") {
                $alias = $table2 . "_" . $field1;
                $join .= " left join " . $table2 . " " . $alias . " on ";
                //$join .= $this->field($table1, $field1, "int") . " = " . $alias . ".id";
                $join .= $this->field($table1, $field1, "text") . " = " . "(" . $alias . ".id" . ")::text";
                
            } else {
                $alias = $domain . "_" . $field1;
                $join .= " inner join " . $table2 . " " . $alias . " on ";
                $join .= $this->field($table1, $field1, "text") . " = " . $this->field($alias, "key", "text");
                $join .= " and " . $this->condition($alias, "domain", "text", " = ", $domain);
            }
            return $join;
        }        
    }

    /*
     * Get messages from database
     */            
    class Message extends Base {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
        }

        public function getStatus($status=0, $message) {

            $json = "";
            $jsonUtil = new JsonUtil();

            // 0 - Fail
            // 1 - Success
            // 2 - Alert
            $json = $jsonUtil->setValue($json, "status", $status);

            // 0 - Fail
            // 1 - Success
            $json = $jsonUtil->setValue($json, "message", $message);

            // Return it
            return $json;
        }

        public function getValue($code, $value="") {

            // General Declaration            
            $html = "";
            $message = "";
            $stringUtil = new StringUtil();

            try {

                // Get data
                $filter = new Filter();
                $filter->addCondition("tb_domain", "key", "text", "=", $code);
                $filter->addCondition("tb_domain", "domain", "text", "=", "tb_message");
                $data = $this->sqlBuilder->executeQuery($this->cn, $this->TB_DOMAIN, $filter->create());

                // Create main menu
                foreach ($data as $row) {
                    $message = $row["value"];
                    if (trim($value) != "" ) {
                        $message = $stringUtil->dqt(str_replace("%", $value, $message));
                    }
                }

            } catch (Exception $ex) {
                throw $ex;
            }

            // Return main menu
            return $message;
        }
    }    
?>