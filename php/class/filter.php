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
         * Create condition based on current form 
         */        
        function setFilter($tableDef, $formData) {

            // General Declaration
            $tableName = "";
            $fieldName = "";
            $fieldValue = "";
            $fieldId = "_id_"; // See createId() on form

            // Create filter
            foreach ($tableDef as $item) {

                // Keep table name
                $tableName = $tableDef[0]["table_name"];

                // ID is not in table def, handle here
                if (isset($formData[$fieldId])) {
                    if ($formData[$fieldId] != "") {
                        $this->addCondition($tableName, 
                                            "id", 
                                            "int", 
                                            "=",
                                            $formData[$fieldId],
                                            "");
                    }
                }

                // Get key fields
                $fieldName = $item["field_name"];
                if (isset($formData[$fieldName])) {
                    $fieldValue = $formData[$fieldName];
                }                

                // Add condition
                if (trim($fieldValue) != "" && trim($fieldValue) != "0") {
                    $this->addCondition($item["table_name"], 
                                        $item["field_name"], 
                                        $item["data_type"], 
                                        "=",
                                        $fieldValue,
                                        $item["field_mask"]);
                }

            }            
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
        function addCondition($tableName="", $fieldName="", $fieldType="", $fieldOperator="", $fieldValue="", $fieldMask="") {
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