<?php

    // General declaration      
    $id = 0;
    $report = "";
    $form = "";
    $tableId = 0;  
    $format = 1;
    $html = "";
    $event = "";
    $eventAction = "";
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
        $eventAction = new EventAction($cn, $sqlBuilder);
        $menu = new Menu($cn, $sqlBuilder);
        $element = new HTMLElement($cn, $sqlBuilder);

        // Get events
        $filter = new Filter();
        $filter->add("tb_event", "id_target", $format);
        $filter->add("tb_event", "id_table", $tableId);
        $pageEvent = $sqlBuilder->Query($cn, $TB_EVENT, $filter->create(), $sqlBuilder->QUERY_NO_PAGING);

        // Create main menu
        $menu->createMenu();
        $mainMenu = $menu->html;        

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
            $html .= $eventAction->createButton($pageEvent);

            // Add global functions (js code)
            $html .= $eventAction->createJSCode();

            // Create form/load events
            $onLoadFunctions = $eventAction->createFormLoad($pageEvent);           
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

?>