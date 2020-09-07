<?php
    class EventAction extends Base {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
        }

        /* 
        * Get event list and isolate function calls related to buttons
        */
        function createButton($pageEvent) {

            // General declaration
            $html = "";
            $name = "";
            $element = "";

            try {
                // Create objects
                $element = new HTMLElement($this->cn, $this->sqlBuilder);

                // Space between form and buttons
                $html = "<br><br>";

                // Create event list
                foreach ($pageEvent as $item) {

                    if ($item["id_action"] != 0) {
                        $name = "btn" . $item["id_table"] . $item["id"];
                        $html .= $element->createButton($name, $item["action"], $item["event"], $item["code"]);
                    }
                }

            } catch (Exception $ex) {                    
                // Error handler
                $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
            } finally {

            }     
            // Return to main function
            return $html;
        }

        /* 
        * Get event list and isolate function calls related to buttons
        */
        function createFormLoad($pageEvent) {

            // General declaration
            $html = "";
            $name = "";
            $element = "";

            try {

                // Create event list
                foreach ($pageEvent as $item) {

                    if ($item["id_event"] == 1) {
                        $html .= $item["code"];
                    }
                }

            } catch (Exception $ex) {                    
                // Error handler
                $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
            } finally {

            }     
            // Return to main function
            return $html;
        }


        /* 
        * Get global js functions
        */
        function createJS() {

            // General declaration
            $js = "";
            $rs = "";

            // Get data
            $filter = new Filter();
            $rs = $this->sqlBuilder->Query($this->cn, $this->TB_CODE, $filter, $this->sqlBuilder->QUERY_NO_PAGING);

            // Create event list
            foreach ($rs as $item) {
                $js .= $item["code"];
            }

            // Append script
            $js = "<script>$js</script>";

            // Return to main function
            return $js;
        }

    // End of class
    }    
?>