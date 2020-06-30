<?php
    class StringUtil {
        // Put value between single quote
        function qt($value) {
            return "'" . trim($value) . "'";
        }
    }
    class JsonUtil {
        // Set value in specific tag
        function setValue($json, $field, $value) {
            $json = json_decode($json, true);
            $json[$field] = $value;
            $json = json_encode($json);
            return $json;
        }
        // Json field
        function jfield($table, $field, $type) {
            $jfield = "";           
            $stringUtil = new StringUtil();
            $jfield = "(" . $table . ".field" . '->>' . $stringUtil->qt($field) . ")::<type> as " . $field;

            return $jfield;
        }
    }
?>