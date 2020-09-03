<?php

    // General declaration      
    $id = 0;
    $report = "";
    $form = "";
    $tableId = 0;  
    $format = 1;
    $html = "";
    $event = "";
    $pageEvent = "";
    $element = "";
    $mainMenu = "";
    $onLoadFunctions = "";
    $TB_EVENT = 5;
    
    try {
        
        // Handle request outside to organize code
        include "request.php";

        // Get main menu    
        $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $groupId);    
        $menu = new Menu($cn, $sqlBuilder);
        $menu->createMenu();
        $mainMenu = $menu->html;
        $onLoadFunctions = "optionClear('id_field');";        

        // General Declaration
        $element = new HTMLElement($cn, $sqlBuilder);

        // Get controls for current table ID
        $filter = new Filter();
        $filter->add("tb_event", "id_target", $format);
        $filter->add("tb_event", "id_table", $tableId);
        $pageEvent = $sqlBuilder->Query($cn, $TB_EVENT, $filter->create());

        // Create table or form
        if ($tableId > 0) {

            // Go to current table
            $sqlBuilder->setTable($tableId);            

            // Create page or form
            if ($format == 1) {
                $report = new Report($cn, $sqlBuilder, $_REQUEST);
                $report->Event = $event;
                $report->PageEvent = $pageEvent;
                $report->PageOffset = $pageOffset;
                $html .= $report->createReport($tableId);
            } else {
                $form = new Form($cn, $sqlBuilder);
                $form->Event = $event;
                $form->PageEvent = $pageEvent;                
                $html .= $form->createForm($tableId, $id);
            }

            // Add buttons to form
            $html .= createButton($format, $tableId);

            // Add global functions (js code)
            $html .= createJS($cn, $sqlBuilder);
        }

    } catch (Exception $ex) {        
        
        // Error handler
        $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';

    } finally {

        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }

    /* 
     * Get event list and isolate function calls related to buttons
     */
    function CreateButton($format, $tableId) {

        // General declaration
        $html = "";
        $name = "";
        global $element;
        global $sqlBuilder;
        global $cn;
        $TB_SYSTEM = 1;
        $TB_EVENT = 5;

        try {

            // Get controls for current table ID
            $filter = new Filter();
            $filter->addCondition("tb_event", "id_target", "int", "=", $format);
            $filter->addCondition("tb_event", "id_table", "int", "=", $tableId);
            $filter->addCondition("tb_event", "id_action", "int", "<>", "0");
            $pageEvent = $sqlBuilder->Query($cn, $TB_EVENT, $filter->create(), $sqlBuilder->QUERY_NO_PAGING);

            // Not found, inherit from tb_system
            if (!$pageEvent) {
                $filter = new Filter();
                $filter->addCondition("tb_event", "id_target", "int", "=", $format);
                $filter->addCondition("tb_event", "id_table", "int", "=", $TB_SYSTEM);
                $filter->addCondition("tb_event", "id_action", "int", "<>", "0");
                $pageEvent = $sqlBuilder->Query($cn, $TB_EVENT, $filter->create(), $sqlBuilder->QUERY_NO_PAGING);
            }

            // Space between form and buttons
            $html = "<br><br>";

            // Create event list
            foreach ($pageEvent as $item) {
                if ($item["id_field"] == 0) {
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
     * Get global js functions
     */
    function createJS($cn, $sqlBuilder) {

        // General declaration
        $js = "";
        $rs = "";
        $TB_CODE = 7;

        // Get data
        $filter = new Filter();
        $rs = $sqlBuilder->Query($cn, $TB_CODE, $filter, $sqlBuilder->QUERY_NO_PAGING);

        // Create event list
        foreach ($rs as $item) {
            $js .= $item["code"];
        }

        // Append script
        $js = "<script>$js</script>";

        // Return to main function
        return $js;
    }

?>