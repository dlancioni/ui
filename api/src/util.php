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
            $jfield .= " " . $operator . " ";
            $jfield .= (is_numeric($value) ? $value : $this->qt($value));
            return $jfield;
        }
        // Join
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