<?php
    class HTMLElement {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
        }

        /* 
         * Create new label
         */
        public function createLabel($label, $name) {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<label for=" . $stringUtil->dqt($name) . ">";
                $html .= $label;
                $html .= "</label>";                
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }

        /* 
         * Create textbox
         */
        public function createTextbox($fieldId, $name, $value, $placeholder="", $disabled=false, $fieldEvent="") {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<input";
                $html .= " type=" . $stringUtil->dqt("text");
                $html .= " id=" . $stringUtil->dqt($name); 
                $html .= " name=" . $stringUtil->dqt($name); 
                $html .= " value=" . $stringUtil->dqt($value);
                $html .= " class=" . $stringUtil->dqt("w3-input w3-border");
                $html .= " style='width:50%'";
                
                if ($placeholder != "")
                    $html .= " placeholder=" . $stringUtil->dqt($placeholder);

                if ($disabled) 
                    $html .= " disabled";

                if ($fieldEvent)    
                    $html .= $this->getEvent($fieldId, $fieldEvent);

                $html .= ">";
                $html .= "<br>";

            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }

        /* 
         * Create textarea
         */
        public function createTextarea($fieldId, $fieldName, $value, $disabled="", $fieldEvent="") {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<textarea";
                $html .= " style='width:50%'";                
                $html .= " id=" . $stringUtil->dqt($fieldName); 
                $html .= " name=" . $stringUtil->dqt($fieldName); 
                $html .= " rows=" . $stringUtil->dqt("10");
                $html .= " cols=" . $stringUtil->dqt("50");
                $html .= " class=" . $stringUtil->dqt("w3-input w3-border");
                $html .= " " . $disabled;

                if ($fieldEvent)
                    $html .= $this->getEvent($fieldId, $fieldEvent);

                $html .= ">";
                $html .= $value;
                $html .= "</textarea>";
                $html .= "<br>";

            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }        
        
        /* 
         * Create dropdown
         */
        public function createDropdown($fieldId, $fieldName, $selectedValue, $dataFk, $fieldKey, $fieldValue, $function, $fieldEvent="", $disabled="") {

            // General declaration
            $html = "";
            $key = "";
            $value = "";
            $selected = "";
            $event = "";
            $stringUtil = new StringUtil();

            try {

                // Open dropdown
                $html .= "<br>";
                $html .= "<select";
                $html .= " id=" . $stringUtil->dqt($fieldName); 
                $html .= " name=" . $stringUtil->dqt($fieldName);
                $html .= " class=" . $stringUtil->dqt("w3-select w3-border");
                $html .= " style='width:50%'";

                if (trim($function) != "") 
                    $html .= $function;

                if ($fieldEvent)
                    $html .= $this->getEvent($fieldId, $fieldEvent);
                    
                $html .= " " . $disabled;
                $html .= ">";

                // Empty item
                $html .= '<option value="0">Selecionar</option>';

                // Add options
                foreach ($dataFk as $item) {

                    // Keep values
                    $key = $item[$fieldKey];
                    $value = $item[$fieldValue];

                    // Handle selected
                    if ($key == $selectedValue) {
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }

                    // Create option
                    $html .= "<option ";
                    $html .= "value=" . $stringUtil->dqt($key) . " " . $selected . ">";
                    $html .= $value;
                    $html .= "</option>";
                }

                // Close dropdown
                $html .= "</select>";

                // Separete controls
                $html .= "<br><br>";

            } catch (Exception $ex) {
                throw $ex;
            }

            // Return filled dropdown
            return $html;            
        }


        /* 
         * Create button
         */
        public function createButton($name, $value, $event, $code) {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<input";
                $html .= " type=" . $stringUtil->dqt("button"); 
                $html .= " name=" . $stringUtil->dqt($name); 
                $html .= " value=" . $stringUtil->dqt($value); 
                $html .= " " . $event . "=" . $stringUtil->dqt($code);
                $html .= " class=" . $stringUtil->dqt("w3-button w3-blue");                 
                $html .= ">";
                $html .= "&nbsp;";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;
        }

        /* 
         * Create radio
         */
        public function createRadio($name, $value, $checked="", $event="") {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<input";                
                $html .= " type=" . $stringUtil->dqt("radio"); 
                $html .= " name=" . $stringUtil->dqt($name); 
                $html .= " value=" . $stringUtil->dqt($value);                 
                $html .= " " . $checked; 
                $html .= " " . $stringUtil->dqt($event); 
                $html .= ">";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;
        }

        /* 
         * Create table
         */
        public function createTable($value) {
            $html = "";
            try {
                $html .="<div style='overflow-x:auto;'>";
                $html .= "<table class='w3-table w3-bordered w3-hoverable'>$value</table>";
                $html .="</div>";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;
        }

        /* 
         * Create row
         */
        public function createTableRow($value) {
            $html = "";
            try {
                $html = "<tr>$value</tr>";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }

        /* 
         * Create header
         */
        public function createTableHeader($value) {
            $html = "";
            try {
                $html = "<th>$value</th>";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;
        }

        /* 
         * Create column
         */
        public function createTableCol($value) {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html = "<td>$value</td>";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }

        /* 
         * Create column
         */
        public function createForm($name, $value) {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html = "<form id=$name>$value</td>";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }        

        /* 
         * Create page title
         */
        public function createPageTitle($tableId, $event="") {

            // General declartion 
            $html = "";
            $pageTitle = "";
            $stringUtil = new StringUtil();

            try {
                $filter = new Filter();
                $filter->add("tb_table", "id", $tableId);
                $data = $this->sqlBuilder->Query($this->cn, $this->sqlBuilder->TB_TABLE, $filter->create(), $this->sqlBuilder->QUERY_NO_PAGING);
                $pageTitle = $data[0]["name"];  
                
                switch ($event) {
                    case "New":
                        $html .= "<h3><i class='fa fa-sticky-note-o' style='font-size:20px;'></i> $pageTitle</h3>";
                        break;
                    case "Edit":
                        $html .= "<h3><i class='fa fa-pencil-square-o' style='font-size:20px;'></i> $pageTitle</h3>";
                        break;
                    case "Delete":
                        $html .= "<h3><i class='fa fa-remove' style='font-size:20px;'></i> $pageTitle</h3>";
                        break;
                    case "Filter":
                        $html .= "<h3><i class='fa fa-filter' style='font-size:20px;'></i> $pageTitle</h3>";
                        break;
                    default:    
                        $html .= "<h3>$pageTitle</h3>";
                }
                

            } catch (Exception $ex) {
                throw $ex;
            }
            
            return $html;
        }      

        /* 
         * Create paging
         */
        public function createPaging($recordCount, $pageSize, $pageOffset) {

            $x = 0;
            $limit = 5;
            $html = "";
            $totalPages = 0;
            $stringUtil = new StringUtil();            
            
            try {

                // If paging is enabled
                if ($pageSize > 0) {

                    // Count pages
                    $totalPages = ceil($recordCount / $pageSize);

                    // Display after two pages
                    if ($totalPages > 1) {

                        // Calculate things to display
                        if ($totalPages > $limit) {
                            $totalPages = $totalPages - $limit;
                        }
    
                        // Create links
                        for ($i=1; $i<=$totalPages; $i++) {
    
                            // Calculate offset
                            $pageOffset = (($i-1) * $pageSize);
    
                            // Define function call                        
                            $html .= "<a onClick='paging($pageOffset);'>$i </a>";
                        }
                    }
                }

            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }


        /* 
         * Get events to bind on fields (textbox, dropdown, etc)
         */
        private function getEvent($fieldId, $fieldEvent) {

            // General declaration
            $html = "";
            $stringUtil = new StringUtil();

            // Bind events related to current field
            foreach ($fieldEvent as $item) {

                // Figure out same field
                if ($fieldId == $item["id_field"]) {
                    $event = $item["event"] . "=" . $stringUtil->dqt($item["code"]) . " ";
                } else {
                    $event = "";
                }

                // Bind field
                ($event != "") ? $html .= " " . $event : "";
            }
            
            // Return event list
            return $html;
        }

        /* 
         * Create script
         */
        public function createScript($js) {

            $html = "";
            $stringUtil = new StringUtil();
            $language = $stringUtil->dqt("JavaScript");
            
            try {

                $html .= "<script language=$language>";
                $html .= "function validateForm() {";
                $html .= $js;
                $html .= "return true";
                $html .= "}";
                $html .= "</script>";

            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;
        }


       /*
        * Javascript generation
        */
        public function createJs($fieldLabel, $fieldName, $fieldType, $fieldValue, $fieldMask, $fieldMandatory, $fk) {

            // General declaration
            $js = "";
            $msg = "";
            $stringUtil = new StringUtil();
            $message = new Message($this->cn, $this->sqlBuilder);

            // Prepare values        
            $fieldName = $stringUtil->dqt($fieldName);
            $fieldMask = $stringUtil->dqt($fieldMask);

            // Validate mandatory fields
            $msg = $message->getValue("A1", $fieldLabel);
            if ($fieldMandatory == 1) {                
                $js .= "if (!validateMandatory($fieldName, $fk, $msg)) {";
                $js .= "return false;";
                $js .= "} ";
            }

            // Validate data type date
            $msg = $message->getValue("A2", $fieldLabel);
            if ($fieldType == "date") {                
                $js .= "if (!validateDate($fieldName, $fieldMask, $msg)) {";
                $js .= "return false;";
                $js .= "} ";
            }

            // Validate datat numeric
            $msg = $message->getValue("A3", $fieldLabel);
            if ($fieldType == "int" || $fieldType == "float") {
                $js .= "if (!validateNumeric($fieldName, $msg)) {";
                $js .= "return false;";
                $js .= "} ";
            }

            // Just return
            return $js;
        }        

        /* 
         * Create cascade function call
         */
        public function createCascade($k, $v) {

            $js = "";
            $html = "";
            $stringUtil = new StringUtil();
            
            try {

                // Very special exception for field table
                if (trim($k[1]) == "id_table_fk") {
                    $k[1] = "id_table";
                }

                // Prepare function call
                $js .= "cascade";
                $js .= "(";
                $js .= $stringUtil->sqt($v[0]);        // Target field
                $js .=  ", ";
                $js .= $stringUtil->sqt($k[1]);        // Base field
                $js .=  ", ";
                $js .= "this.value";                   // Base value
                $js .=  ", ";
                $js .= $stringUtil->sqt($v[1]);        // Source table
                $js .=  ", ";
                $js .= $stringUtil->sqt($v[2]);        // Source ID
                $js .=  ", ";
                $js .= $stringUtil->sqt($v[3]);        // Source DS
                $js .= ")";
                
                // Set up event
                $html .= " onChange=" . $stringUtil->dqt($js) . ";";

            } catch (Exception $ex) {
                throw $ex;
            }

            // Return final function call
            return $html;
        }        

    // End of class
    }
?>