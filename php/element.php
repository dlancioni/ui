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
                throw $ex;
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

                if ($disabled) 
                    $html .= " disabled";

                $html .= ">";

            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }
        
        /* 
         * Create dropdown
         */
        public function createDropdown($name, $selectedValue, $data, $fieldKey, $fieldValue, $event="") {

            // General declaration
            $html = "";
            $key = "";
            $value = "";
            $selected = "";
            $stringUtil = new StringUtil();

            try {

                // Open dropdown
                $html .= "<select";
                $html .= " id=" . $stringUtil->dqt($name); 
                $html .= " name=" . $stringUtil->dqt($name);
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
         * Get page events
         */
        public function createEvent($cn, $sqlBuilder, $tableId, $format) {

            // General Declaration
            $sql = "";
            $data = "";
            $html = "";
            $filter = "";
            $stringUtil = "";
            $TB_EVENT = 5;

            try {

                // Create instances
                $db = new Db();
                $stringUtil = new StringUtil();

                // Get events (buttons)
                $html .= "<br>";
                $filter = new Filter();
                $filter->add("tb_event", "id_target", $format);
                $filter->add("tb_event", "id_table", $tableId);
                $sql = $sqlBuilder->getQuery($cn, $TB_EVENT, $filter->create());
                $data = $db->queryJson($cn, $sql); 
                
                foreach ($data as $item) {
                    $html .= $this->createButton($item["name"], 
                                                 $item["label"], 
                                                 $item["event"],
                                                 $item["code"]);
                }                
            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;            
        }

    // End of class
    }
?>