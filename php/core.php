<?php

    // General declaration      
    $id = 0;
    $logicReport = "";
    $logicForm = "";
    $tableId = 0;  
    $format = 1;
    $html = "";
    $event = "";
    $eventAction = "";
    $pageEvent = "";
    $element = "";    
    $onLoadFunctions = "";
    
    try {
        
        // Handle request outside to organize code
        include "request.php";

        // Get main menu
        $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $groupId);        
        $eventAction = new EventAction($cn, $sqlBuilder);
        $logicMenu = new LogicMenu($cn, $sqlBuilder);
        $element = new HTMLElement($cn, $sqlBuilder);

        // Get events
        $filter = new Filter();
        $filter->add("tb_event", "id_target", $format);
        $filter->add("tb_event", "id_table", $tableId);
        $pageEvent = $sqlBuilder->executeQuery($cn, $sqlBuilder->TB_EVENT, $filter->create(), $sqlBuilder->QUERY_NO_PAGING);

        // Create table or form
        if ($tableId > 0) {

            // Go to current table
            $sqlBuilder->setTable($tableId);

            // Create page or form
            if ($format == 1) {
                $logicReport = new LogicReport($cn, $sqlBuilder, $_REQUEST);
                $logicReport->Event = $event;
                $logicReport->PageEvent = $pageEvent;
                $html .= $logicReport->createReport($tableId, $pageOffset);
            } else {
                $logicForm = new LogicForm($cn, $sqlBuilder);
                $logicForm->Event = $event;
                $logicForm->PageEvent = $pageEvent;                
                $html .= $logicForm->createForm($tableId, $id);
            }

            // Add buttons to form
            $sqlBuilder->setTable($tableId);            
            $html .= $eventAction->createButton($pageEvent);

            // Add global functions (js code)
            $html .= $eventAction->createJS();

            // Create form/load events
            $onLoadFunctions = $eventAction->createFormLoad($pageEvent);           
        }

    } catch (Exception $ex) {        
        
        // Error handler
        $html = $ex->getMessage();
    }

    // Close connection
    if ($cn) {
        pg_close($cn); 
    }    

?>