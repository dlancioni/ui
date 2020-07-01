<?php
    class StringUtil {
        // Put value between single quote
        function qt($value) {
            return "'" . trim($value) . "'";
        }
    }
    class JsonUtil extends StringUtil {
        // Set value in specific tag
        function setValue($json, $field, $value) {
            $json = json_decode($json, true);
            $json[$field] = $value;
            $json = json_encode($json);
            return $json;
        }
        // Plain field
        function jfield($table, $field, $type) {
            $jfield = "(" . $table . ".field" . '->>' . $this->qt($field) . ")::" . $type;
            return $jfield;
        }
        // Select
        function jsel($table, $field, $type, $alias="") {
            $jfield = $this->jfield($table, $field, $type) . " as " . (trim($alias) == "" ? $field : $alias);
            return $jfield;
        }
        // Condition
        function jcond($table, $field, $type, $operator, $value) {
            $jfield = $this->jfield($table, $field, $type);
            $jfield += $operator;
            $jfield += (is_numeric($value) ? $value : $this->qt($value));
            return $jfield;
        }
        //Join
        function jjoin($table1, $field1, $table2, $alias2, $field2, $domain) {
            $join = "";
            $fieldType = (trim($domain) == "" ? "int" : "text");
            $joinType = (trim($domain) == "" ? "left" : "inner");
            $join += " $joinType join " . $table2 . " " . $alias2 . " on ";
            $join += $this->jfield($table1, $field1, $fieldType) . " = " . $this->jfield($alias2, $field2, $fieldType);
            $join += $this->jcond($table2, $field2, $fieldType, " = ", $domain)
            return $jfield;
        }        
    }
?>