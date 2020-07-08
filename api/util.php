<?php
    class StringUtil {

        /*
         * Put value between single quote
         */        
        function qt($value) {
            return "'" . trim($value) . "'";
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
            $json[$field] = $value;
            $json = json_encode($json);
            return $json;
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
                    $output = "to_date(" . $table . ".field" . '->>' . $this->qt($field) . ", " . $this->qt($mask) . ")";
                } else {
                    $output = "(" . $table . ".field" . '->>' . $this->qt($field) . ")::" . $type;
                }
            }

            return $output;
        }

        /*
         * Select field
         */
        public function select($table, $field, $type, $alias="") {
            $output = "";
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
            $value = (is_numeric($value) ? $value : $this->qt($value));
            // Set value
            if ($type == "date") {
                $condition .= "to_date(" . $value . ", " . $this->qt($mask) . ")";
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
                $join .= $this->field($table1, $field1, "int") . " = " . $alias . ".id";
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