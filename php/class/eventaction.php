<?php
    class EventAction extends Base {

        // Private members
        private $cn = "";

        // Constructor
        function __construct($cn) {
            $this->cn = $cn;
        }

        /* 
        * Get event list and isolate function calls related to buttons
        */
        function createButton($moduleId, $userId, $target, $event) {

            // General declaration
            $html = "";
            $name = "";
            $filter = "";
            $element = "";
            $events = array();
            $element = new HTMLElement($this->cn);

            try {

                // Get related events
                $events = $this->getEventByModule($moduleId, $userId, $target, $event);

                // Create event list
                $html .= "<br>";
                foreach ($events as $event) {                   
                    $name = "btn" . $moduleId . $event["id"];
                    $html .= $element->createButton($name, $event["name"], $event["event"], $event["code"]);
                }

            } catch (Exception $ex) {                    
                throw $ex;
            }

            return $html;
        }

        /* 
        * Get event list and isolate function calls related to buttons
        */
        function createFormLoad($moduleId, $target) {

            // General declaration
            $html = "";
            $filter = "";
            $event = array();
            $sqlBuilder = "";

            try {

                $sqlBuilder = new SqlBuilder();                
                $filter = new Filter();
                $filter->add("tb_event", "id_module", $moduleId);
                $filter->add("tb_event", "id_target", $target);
                $filter->add("tb_event", "id_event", $this->EVENT_LOAD);
                $event = $sqlBuilder->executeQuery($this->cn, $this->TB_EVENT, 0, $filter->create(), $sqlBuilder->QUERY_NO_PAGING);

                // Create event list
                foreach ($event as $item) {
                    $html .= $item["code"];
                }

            } catch (Exception $ex) {                    
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
            $sqlBuilder = new SqlBuilder();
            $rs = $sqlBuilder->executeQuery($this->cn, $this->TB_CODE, $viewId, $filter, $sqlBuilder->QUERY_NO_PAGING);

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
        * Get module function by profile user
        */
        private function getEventByModule($moduleId, $userId, $target, $event) {

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
                $sql .= " tb_event.id," . $lb; 
                $sql .= " tb_event.field->>'name' as name," . $lb;
                $sql .= " tb_event.field->>'code' as code," . $lb;
                $sql .= " tb_domain.field->>'value' as event" . $lb;
                $sql .= " from tb_user_profile" . $lb; 
                $sql .= " inner join tb_profile_module on (tb_profile_module.field->>'id_profile')::int = (tb_user_profile.field->>'id_profile')::int" . $lb; 
                $sql .= " inner join tb_event on (tb_profile_module.field->>'id_event')::int = tb_event.id" . $lb; 
                $sql .= " inner join tb_domain on (tb_event.field->>'id_event')::int = (tb_domain.field->>'key')::int and (tb_domain.field->>'domain')::text = 'tb_event'" . $lb; 
                $sql .= " where (tb_profile_module.field->>'id_module')::int = " . $moduleId . $lb;
                $sql .= " and (tb_user_profile.field->>'id_user')::int = " . $userId . $lb;
                $sql .= " and (tb_event.field->>'id_target')::int = " . $target . $lb;
                $sql .= " and (tb_event.field->>'name')::text <> ''" . $lb;

                if ($event == $this->EVENT_DETAIL) {
                    $sql .= " and tb_event.id = " . $this->EVENT_BACK . $lb;
                }

                $sql .= " order by tb_event.id" . $lb;

                // Execute query
                $rs = $db->queryJson($this->cn, $sql);

            } catch (Exception $ex) {

                $this->setError("QueryBuilder.getEventByModule()", $ex->getMessage());
                throw $ex;
            }

            // Return data
            return $rs;
        }


    // End of class
    }    
?>