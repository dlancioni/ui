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
        function createButton($pageEvent, $format) {

            // General declaration
            $html = "";
            $name = "";
            $filter = "";
            $element = "";
            $permission = array();
            $FunctionByProfileUser = 2;

            try {
                // Create objects
                $element = new HTMLElement($this->cn, $this->sqlBuilder);

                // Get access control
                $filter = new Filter();
                $filter->add("tb_table", "id_table", $this->sqlBuilder->getTable());
                $filter->add("tb_user_profile", "id_user", $this->sqlBuilder->getUser());
                $permission = $this->sqlBuilder->executeView($this->cn, $FunctionByProfileUser, $filter->create());

                $html .= "<br>";

                // Create event list
                if (is_array($pageEvent) && is_array($permission)) {
                    foreach ($pageEvent as $event) {
                        if ($event["id_target"] == $format) {
                            if ($event["id_function"] != 0) {
                                foreach ($permission as $item) {
                                    if ($event["id_function"] == $item["id"]) {
                                        $name = "btn" . $event["id_table"] . $event["id"];
                                        $html .= $element->createButton($name, $event["function"], $event["event"], $event["code"]);
                                        break;
                                    }
                                }
                            }
                        }                        
                    }
                }

            } catch (Exception $ex) {                    
                throw $ex;
            }

            // Return to main function
            return $html;
        }

        /* 
        * Get event list and isolate function calls related to buttons
        */
        function createFormLoad($pageEvent, $format) {

            // General declaration
            $html = "";
            $name = "";
            $element = "";

            try {

                // Create event list
                foreach ($pageEvent as $item) {
                    if ($item["id_target"] == $format) {
                        if ($item["id_event"] == 1) {
                            $html .= $item["code"];
                        }
                    }
                }

            } catch (Exception $ex) {                    
                // Error handler
                throw $ex;
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
            $rs = $this->sqlBuilder->executeQuery($this->cn, $this->TB_CODE, $filter, $this->sqlBuilder->QUERY_NO_PAGING);

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