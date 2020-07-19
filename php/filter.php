<?php
    class Filter {
        /*
         * Used to keep a list of conditions
         */
        private $condition = [];

        /*
         * Main constructor
         */
        function constructor() {
            $condition = [];
        }

        /*
         * Add a simple integer condition
         */
        function add($tableName, $fieldName, $fieldValue) {

            // General declaration
            $fieldType = "int";
            $jsonUtil = new JsonUtil();

            // Handle non-numeric values
            if (is_numeric($fieldValue) == false) {
                $fieldType = "text";
            }

            // Create criteria
            $json = "";
            $json = $jsonUtil->setValue($json, "table", $tableName);
            $json = $jsonUtil->setValue($json, "field", $fieldName);
            $json = $jsonUtil->setValue($json, "type", $fieldType);
            $json = $jsonUtil->setValue($json, "operator", "=");
            $json = $jsonUtil->setValue($json, "value", $fieldValue);
            $json = $jsonUtil->setValue($json, "mask", "");

            // Add to be generated
            array_push($this->condition, $json);
        }

        /*
         * Add a complex condition
         */        
        function add1($tableName = "", $fieldName = "", $fieldValue = "", $fieldType = "", $fieldOperator = "", $fieldMask = "") {
            $jsonUtil = new JsonUtil();
            $json = "";
            $json = $jsonUtil->setValue($json, "table", $tableName);
            $json = $jsonUtil->setValue($json, "field", $fieldName);
            $json = $jsonUtil->setValue($json, "type", $fieldType);
            $json = $jsonUtil->setValue($json, "operator", $fieldOperator);
            $json = $jsonUtil->setValue($json, "value", $fieldValue);
            $json = $jsonUtil->setValue($json, "mask", $fieldMask);
            array_push($this->condition, $json);
        }

        /*
         * Return all conditions as json array
         */        
        function create() {
            $output = "[";
            foreach ($this->condition as $item) {
                $output .= $item . ",";
            }                        
            $output .= "]";
            $output = str_replace(",]", "]", $output);
            return $output;
        }
    }
?>    