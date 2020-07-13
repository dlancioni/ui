<?php
    class HTMLElement {
  
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
                throw $err;
            }
            return $html;            
        }

        /* 
         * Create textbox
         */
        public function createTextbox($name, $value, $placeholder="", $disabled=false) {
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

                if (disabled) 
                    $html .= " disabled";

                $html .= ">";

            } catch (Exception $ex) {
                throw $err;
            }
            return $html;            
        }
        
        /* 
         * Create dropdown
         */
        public function createDropdown($name, $value, $data) {
            $stringUtil = new StringUtil();
            $html = "";
            try {
                $html .= " <select";
                $html .= " id=" . $stringUtil->dqt($name); 
                $html .= " name=" . $stringUtil->dqt($name); 
                $html .= ">";
                //$html .= " <option value="" selected></option>"; 
                $html .= " </select>";
                return $html.trim();
            } catch (Exception $ex) {
                throw $err;
            }
        }


        /* 
         * Create button
         */
        public function createButton($name, $value, $event) {
            $html = "";
            $stringUtil = new StringUtil();
            try {
                $html .= "<input ";
                $html .= " type=" . $stringUtil->dqt("button"); 
                $html .= " name=" . $stringUtil->dqt($name); 
                $html .= " value=" . $stringUtil->dqt($value); 
                $html .= $stringUtil->dqt($value); 
                $html .= ">"; 
            } catch (Exception $ex) {
                throw $err;
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
                $html .= "<input ";                
                $html .= " type=" . $stringUtil->dqt("radio"); 
                $html .= " name=" . $stringUtil->dqt($name); 
                $html .= " value=" . $stringUtil->dqt($value);                 
                $html .= " " . $stringUtil->dqt($checked); 
                $html .= " " . $stringUtil->dqt($event); 
                $html .= ">";
            } catch (Exception $ex) {
                throw $err;
            }
            return $html;
        }

        /* 
         * Create table
         */
        public function createTable($value) {
            $html = "";
            try {
                $html = "<table>" . $value . "</table>";
            } catch (Exception $ex) {
                throw $err;
            }
            return $html;
        }

        /* 
         * Create row
         */
        public function createTableRow($value) {
            $html = "";
            try {
                $html = "<tr>" . $value . "</tr>";
            } catch (Exception $ex) {
                throw $err;
            }
            return $html;            
        }

        /* 
         * Create header
         */
        public function createTableHeader($value) {
            $html = "";
            try {
                $html = "<th>" . $value.trim() . "</th>";
            } catch (Exception $ex) {
                throw $err;
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
                $html = "<td>" . $value . "</td>";
            } catch (Exception $ex) {
                throw $err;
            }
            return $html;            
        }
    // End of class
    }
?>