<?php
    class HTMLElement {

        // Private members
        private $cn = 0;

        // Constructor
        function __construct($cn) {
            $this->cn = $cn;
        }

        /* 
         * Create new label
         */
        public function createLabel($label, $name) {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<label for=" . $stringUtil->dqt($name);
                $html .= " class=" . $stringUtil->dqt("col-sm-2 col-form-label") . ">";
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
        public function createUpload($fieldId, $name, $value, $placeholder="", $disabled=false) {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<input";
                $html .= " type=" . $stringUtil->dqt("file");
                $html .= " id=" . $stringUtil->dqt($name); 
                $html .= " name=" . $stringUtil->dqt($name); 
                $html .= " value=" . $stringUtil->dqt($value);
                $html .= " class=" . $stringUtil->dqt("form-control");
                $html .= " style='width:50%'";
                $html .= ">";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }

        /* 
         * Create textbox
         */
        public function createTextbox($fieldId, $fieldType, $fieldName, $fieldValue, $placeholder="", $disabled=false, $fieldEvent="") {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<input";
                $html .= " type=" . $stringUtil->dqt($fieldType);
                $html .= " id=" . $stringUtil->dqt($fieldName); 
                $html .= " name=" . $stringUtil->dqt($fieldName); 
                $html .= " value=" . $stringUtil->dqt($fieldValue);
                $html .= " class=" . $stringUtil->dqt("form-control");
                
                if ($placeholder != "")
                    $html .= " placeholder=" . $stringUtil->dqt($placeholder);

                if ($disabled) 
                    $html .= " disabled";

                if ($fieldEvent)    
                    $html .= $this->getAction($fieldId, $fieldEvent);

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
                $html .= " cols=" . $stringUtil->dqt("100");
                $html .= " class=" . $stringUtil->dqt("form-control");
                $html .= " " . $disabled;

                if ($fieldEvent)
                    $html .= $this->getAction($fieldId, $fieldEvent);

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
        public function createDropdown($fieldId, $fieldName, $selectedValue, $dataFk, $fieldKey, $fieldValue, $function, $fieldEvent="", $disabled="") {

            // General declaration
            $html = "";
            $key = "";
            $value = "";
            $selected = "";
            $action = "";
            $stringUtil = new StringUtil();

            try {

                // Open dropdown
                $html .= "<select";
                $html .= " id=" . $stringUtil->dqt($fieldName); 
                $html .= " name=" . $stringUtil->dqt($fieldName);
                $html .= " class=" . $stringUtil->dqt("custom-select my-1 mr-sm-2");

                if (trim($function) != "") 
                    $html .= $function;

                if ($fieldEvent)
                    $html .= $this->getAction($fieldId, $fieldEvent);
                    
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


            } catch (Exception $ex) {
                throw $ex;
            }

            // Return filled dropdown
            return $html;            
        }

        /* 
         * Create dropdown
         */
        public function createSimpleDropdown($fieldName, $data, $key, $value, $selectedValue="", $event) {

            // General declaration
            $html = "";
            $code = "";
            $description = "";
            $stringUtil = new StringUtil();

            try {

                // Open dropdown
                $html .= "<select";
                $html .= " id=" . $stringUtil->dqt($fieldName); 
                $html .= " name=" . $stringUtil->dqt($fieldName);
                $html .= " class=" . $stringUtil->dqt("custom-select my-1 mr-sm-2");
                $html .= " " . $event;
                $html .= ">";

                // Empty item
                $html .= '<option value="0">Selecionar</option>';

                // Add options
                foreach ($data as $item) {

                    // Keep values
                    $code = $item[$key];
                    $description = $item[$value];

                    // Handle selected
                    if ($code == $selectedValue) {
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }

                    // Create option
                    $html .= "<option ";
                    $html .= "value=" . $stringUtil->dqt($code) . " " . $selected . ">";
                    $html .= $description;
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
        public function createButton($name, $value, $action, $code) {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<input";
                $html .= " type=" . $stringUtil->dqt("button"); 
                $html .= " name=" . $stringUtil->dqt($name); 
                $html .= " value=" . $stringUtil->dqt($value); 
                $html .= " " . $action . "=" . $stringUtil->dqt($code);
                $html .= " class=" . $stringUtil->dqt("btn btn-primary");                 
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
        public function createRadio($name, $value, $checked="", $action="") {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<input";                
                $html .= " type=" . $stringUtil->dqt("radio"); 
                $html .= " name=" . $stringUtil->dqt($name); 
                $html .= " value=" . $stringUtil->dqt($value);                 
                $html .= " " . $checked; 
                $html .= " " . $stringUtil->dqt($action); 
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
            $stringUtil = new StringUtil();

            try {
                $html .="<div style='overflow-x:auto;'>";
                $html .= "<table class=" . $stringUtil->dqt("table table-borderless table-hover table-sm"); 
                $html .= $value;
                $html .="</table>";
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
                $html .= "<tr>";
                $html .= $value;
                $html .= "</tr>";
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
                $html .= "<th>";
                $html .= $value;
                $html .= "</th>";
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;
        }

        /* 
         * Create column
         */
        public function createTableCol($value, $width="") {

            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<td ";

                if ($width != "") {
                    $width = "width: " . $width . "%";
                    $html .= "style=" . $stringUtil->dqt($width);
                }
                
                $html .= ">";
                $html .= $value;
                $html .= "</td>";

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
        public function createPageTitle($pageTitle) {

            $html = "";
            $html .= "<h3>$pageTitle</h3>";
            $html .= "<br>";
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
                            //$totalPages = $totalPages - $limit;
                        }
    
                        // Create links
                        for ($i=1; $i<=$totalPages; $i++) {
    
                            // Calculate offset
                            $pageOffset = (($i-1) * $pageSize);
    
                            // Define function call                        
                            $html .= "<a href='#' onClick='paging($pageOffset);'>$i </a>";
                        }

                        // Extra line
                        $html .= "<br>";
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
        private function getAction($fieldId, $fieldEvent) {

            // General declaration
            $html = "";
            $stringUtil = new StringUtil();

            // Bind events related to current field
            foreach ($fieldEvent as $item) {

                if (trim($item["id_target"]) == "2") {

                    // Figure out same field
                    if ($fieldId == $item["id_field"]) {
                        $action = $item["event"] . "=" . $stringUtil->dqt($item["code"]) . " ";
                    } else {
                        $action = "";
                    }

                    // Bind field
                    ($action != "") ? $html .= " " . $action : "";
                }
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
        public function createJs($fieldLabel, $fieldName, $fieldType, $fieldValue, $fieldMask, $fieldMandatory, $fk, $action) {

            // General declaration
            $js = "";
            $msg = "";
            $stringUtil = new StringUtil();
            $message = new Message($this->cn);

            // Prepare values        
            $fieldName = $stringUtil->dqt($fieldName);
            $fieldMask = $stringUtil->dqt($fieldMask);

            // Validate mandatory fields
            if ($action != "Filter") {
                $msg = $message->getValue("M1", $fieldLabel);
                if ($fieldMandatory == 1) {                
                    $js .= "if (!validateMandatory($fieldName, $fk, $msg)) {";
                    $js .= "return false;";
                    $js .= "} ";
                }
            }

            // Validate data type date
            $msg = $message->getValue("M2", $fieldLabel);
            if ($fieldType == "date") {                
                $js .= "if (!validateDate($fieldName, $fieldMask, $msg)) {";
                $js .= "return false;";
                $js .= "} ";
            }

            // Validate datat numeric
            $msg = $message->getValue("M3", $fieldLabel);
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


        /* 
         * Create link
         */
        public function createLink($image, $label, $path, $download=false) {

            $html = "";
            $stringUtil = new StringUtil();

            try {

                $html .= "<a href=" . $stringUtil->dqt($path);

                if ($download) {
                    $html .= " download=" . $stringUtil->dqt($label);
                }

                $html .= ">";
                $html .= $image;
                $html .= "</a>";

            } catch (Exception $ex) {
                throw $ex;
            }
            
            return $html;            
        }

        /* 
         * Create link
         */
        public function createImage($path) {

            $html = "";
            $stringUtil = new StringUtil();

            try {

                //$html .= "<img src=" . $stringUtil->dqt($path);
                $html .= "<img src='img/icon.png'";
                $html .= " width=" . $stringUtil->dqt("20");
                $html .= " heigth=" . $stringUtil->dqt("20");
                $html .= ">";

            } catch (Exception $ex) {
                throw $ex;
            }
            
            return $html;            
        }



        /* 
         * Create field group
         */
        public function createFieldGroup($label, $control) {

            $html = "";
            $stringUtil = new StringUtil();

            try {

                //$html .= "<div class=" . $stringUtil->dqt("form-group row w-75") . ">";
                $html .= "<div class=" . $stringUtil->dqt("form-group row") . ">";
                    $html .= $label;
                    $html .= "<div class=" . $stringUtil->dqt("col-sm-10") . ">";
                    $html .= $control;
                    $html .= "</div>";
                $html .= "</div>";

            } catch (Exception $ex) {
                throw $ex;
            }
            
            return $html;            
        }        

        public function getAlert($header, $message) {

            $html = "<br>";
            $html .= "<div class='alert alert-danger' role='alert'>";
            $html .= "<p>$header</p>";
            $html .= "<hr>";
            $html .= "<p class='mb-0'>$message</p>";
            $html .= "</div>";

            return $html;
        }

        public function createPanel($item1="") {

            // General declaration
            $html = "";

            $html .= "<div class='modal fade' id='modalPanel' tabindex='-1' role='dialog'>";
                $html .= "<div class='modal-dialog modal-dialog-centered' role='document'>";
                    $html .= "<div class='modal-content'>";

                        $html .= "<div class='modal-header'>";
                            $html .= "<h5 class='modal-title' id='exampleModalLongTitle'>Painel</h5>";
                            $html .= "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                            $html .= "<span aria-hidden='true'>&times;</span>";
                            $html .= "</button>";
                        $html .= "</div>";

                        $html .= "<!-- Body -->";
                        $html .= "<div class='modal-body'>";

                        if (trim($item1) != "") {
                            $html .= $item1;
                        }

                        $html .= "</div>";
                    $html .= "</div>";
                $html .= "</div>";
            $html .= "</div>";

            // Return new panel
            return $html;
        }

    // End of class
    }
?>