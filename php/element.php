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

                if ($placeholder != "")
                    $html .= " placeholder=" . $stringUtil->dqt($placeholder);

                if ($disabled) 
                    $html .= " disabled";

                if ($fieldEvent)    
                    $html .= $this->getEvent($fieldId, $fieldEvent);

                $html .= ">";

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
                $html .= " id=" . $stringUtil->dqt($fieldName); 
                $html .= " name=" . $stringUtil->dqt($fieldName); 
                $html .= " rows=" . $stringUtil->dqt("10");
                $html .= " cols=" . $stringUtil->dqt("50");
                $html .= " " . $disabled;

                if ($fieldEvent)
                    $html .= $this->getEvent($fieldId, $fieldEvent);

                $html .= ">";
                $html .= $value;
                $html .= "</textarea>";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }        
        
        /* 
         * Create dropdown
         */
        public function createDropdown($fieldId, $name, $selectedValue, $data, $fieldKey, $fieldValue, $fieldEvent="", $disabled="") {

            // General declaration
            $html = "";
            $key = "";
            $value = "";
            $selected = "";
            $event = "";
            $stringUtil = new StringUtil();

            try {

                // Open dropdown
                $html .= "<select";
                $html .= " id=" . $stringUtil->dqt($name); 
                $html .= " name=" . $stringUtil->dqt($name);

                if ($fieldEvent)
                    $html .= $this->getEvent($fieldId, $fieldEvent);
                    
                $html .= " " . $disabled;
                $html .= ">";

                // Empty item
                $html .= '<option value="0">Select</option>';

                // Add options
                foreach($data as $item) {

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
                $html = "<table>$value</table>";
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
        public function createPageTitle($value) {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html = "<h4>$value</h4>";
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
            $stringUtil = new StringUtil();
            $totalPages = 0;
            
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
                $html .= "}";
                $html .= "</script>";

            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;
        }

    // End of class
    }
?>