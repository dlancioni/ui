<?php
    class StringUtil {
        // Put value between single quote
        function qt($value) {
            return "'" . trim($value) . "'";
        }
        // Line break
        function lb() {
            return "\n";
        }        
    }
    class JsonUtil extends StringUtil {
        // Set value in specific tag
        public function setValue($json, $field, $value) {
            $json = json_decode($json, true);
            $json[$field] = $value;
            $json = json_encode($json);
            return $json;
        }
        // Plain field
        public function field($table, $field, $type) {
            $jfield = "(" . $table . ".field" . '->>' . $this->qt($field) . ")::" . $type;
            return $jfield;
        }
        // Select
        public function select($table, $field, $type, $alias="") {
            $jfield = $this->field($table, $field, $type) . " as " . (trim($alias) == "" ? $field : $alias);
            return $jfield;
        }
        // Condition
        public function condition($table, $field, $type, $operator, $value) {
            $jfield = $this->field($table, $field, $type);
            $jfield .= $operator;
            $jfield .= (is_numeric($value) ? $value : $this->qt($value));
            return $jfield;
        }
        // Join
        public function join($table1, $field1, $table2, $alias2, $field2, $domain="") {
            // General declaration
            $join = "";
            $fieldType = "int";
            $joinType = "left";
            // Domain use inner
            if (trim($domain) != "") {
                $fieldType = "text";
                $joinType = "inner";
            }
            if (trim($alias2) == "") {
                $alias2 = $table2;
            }
            // Prepare base join
            $join .= " $joinType join " . $table2 . " " . $alias2 . " on ";
            $join .= $this->field($table1, $field1, $fieldType) . " = " . $this->field($alias2, $field2, $fieldType);
            // Domain
            if (trim($domain) != "") {
                $join .= " and " . $this->condition($table2, $field2, $fieldType, " = ", $domain);
            }
            return $join;
        }        
    }
?>