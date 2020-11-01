<?php
    class Filter {
        /*
         * Used to keep a list of conditions
         */
        private $condition = Array();
        private $operatorForTextComparison = "";

        /*
         * Main constructor
         */
        function __construct($operatorForTextComparison="=") {
            $condition = Array();
            $this->operatorForTextComparison = $operatorForTextComparison;
        }

        /*
         * Create condition based on current form 
         */        
        function setFilter($tableDef, $formData) {

            // General Declaration
            $tableName = "";
            $fieldName = "";
            $fieldType = "";
            $fieldValue = "";
            $fieldOperator = "";
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
                $fieldType = $item["data_type"];
                $fieldOperator = "=";

                if (isset($formData[$fieldName])) {
                    $fieldValue = $formData[$fieldName];
                }                

                // Use like or = for text comparison
                if ($fieldType == "text") {
                    if ($this->operatorForTextComparison == "like") {
                        $fieldOperator = "like";
                        $fieldValue = $this->prepareValueForLike($fieldValue);
                    } else {
                        $fieldOperator = "=";                        
                    }
                }

                // Add condition
                if (trim($fieldValue) != "" && trim($fieldValue) != "0") {
                    $this->addCondition($item["table_name"], 
                                        $item["field_name"], 
                                        $item["data_type"], 
                                        $fieldOperator,
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
            $fieldOperator = "";
            $fieldType = "int";
            $jsonUtil = new JsonUtil();

            // Handle non-numeric values
            if (is_numeric($fieldValue) == false) {
                $fieldType = "text";
            }

            $fieldOperator = "=";

            // Use like or = for text comparison
            if ($fieldType == "text") {
                if ($this->operatorForTextComparison == "like") {
                    $fieldOperator = "like";
                    $fieldValue = $this->prepareValueForLike($fieldValue);
                } else {
                    $fieldOperator = "=";                        
                }
            }

            // Create criteria
            $json = "";
            $json = $jsonUtil->setValue($json, "table", $tableName);
            $json = $jsonUtil->setValue($json, "field", $fieldName);
            $json = $jsonUtil->setValue($json, "type", $fieldType);
            $json = $jsonUtil->setValue($json, "operator", $fieldOperator);
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

            // Use like or = for text comparison
            if ($fieldType == "text") {
                if ($this->operatorForTextComparison == "like") {
                    $fieldOperator = "like";
                    $fieldValue = $this->prepareValueForLike($fieldValue);
                } else {
                    $fieldOperator = "=";                        
                }
            }

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

        function prepareValueForLike($value) {

            if (trim($value) != "") {
                // Avoid duplication
                $value = str_replace("%", "", $value);
                // Add like signal
                $value = "%" . $value . "%";
            }

            return $value;
        }

    }
?>    