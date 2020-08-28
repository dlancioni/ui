<?php

    class NumberUtil {
       /*
        * Make number in english (remove , or .)
        */        
        function valueOf($value) {
            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);
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
    }
    
    class JsonUtil extends StringUtil {
        /*
         * Set value in specific tag
         */
        public function setValue($json, $field, $value) {
            $json = json_decode($json, true);

            if (is_numeric($value)) {
                $json[$field] = intval($value);
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
            if ($type == "date") {
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
                    // Numeric, do nothing
                    break;
                default:
                    // Set dbqt
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
?>