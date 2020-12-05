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
                $permission = $this->getFunctionByProfileUser($this->sqlBuilder->getTable(), $this->sqlBuilder->getUser());

                // Create event list
                $html .= "<br>";                
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
            $viewId = 0;

            // Get data
            $filter = new Filter();
            $rs = $this->sqlBuilder->executeQuery($this->cn, $this->TB_CODE, $viewId, $filter, $this->sqlBuilder->QUERY_NO_PAGING);

            // Create event list
            foreach ($rs as $item) {
                $js .= $item["code"];
            }

            // Append script
            $js = "<script>$js</script>";

            // Return to main function
            return $js;
        }


       /*
        * Get table function by profile user
        */
        private function getFunctionByProfileUser($tableId, $userId) {

            // General declaration    
            $rs = "";
            $sql = "";
            $db = new Db();
            $stringUtil = new StringUtil();

            try {

                // Get separator
                $lb = $stringUtil->lb();

                // Query menus and modules
                $sql .= " select distinct" . $lb; 
                $sql .= " tb_user_profile.field->>'id_profile' id_profile," . $lb; 
                $sql .= " tb_action.id," . $lb; 
                $sql .= " tb_action.field->>'name' as name" . $lb; 
                $sql .= " from tb_user_profile" . $lb; 
                $sql .= " inner join tb_table_function on (tb_table_function.field->>'id_profile')::int = (tb_user_profile.field->>'id_profile')::int" . $lb; 
                $sql .= " inner join tb_action on (tb_table_function.field->>'id_function')::int = tb_action.id" . $lb; 
                $sql .= " where (tb_table_function.field->>'id_table')::int = " . $tableId . $lb;
                $sql .= " and (tb_user_profile.field->>'id_user')::int = " . $userId . $lb;
                $sql .= " order by tb_action.id" . $lb;

                // Execute query
                $rs = $db->queryJson($this->cn, $sql);

            } catch (Exception $ex) {

                // Set error
                $this->setError("QueryBuilder.getFunctionByProfileUser()", $ex->getMessage());
            }

            // Return data
            return $rs;
        }


    // End of class
    }    
?>