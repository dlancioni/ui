<?php

    // General declaration      
    $id = 0;
    $logicReport = "";
    $logicForm = "";
    $tableId = 0;  
    $format = 1;
    $html = "";
    $event = "";
    $onLoadFunctions = "";
    
    try {
        
        // Handle request outside to organize code
        include "request.php";

        // Create table or form
        if ($tableId > 0) {

            // Go to current table
            $sqlBuilder->setTable($tableId);

            // Create page or form
            if ($format == 1) {
                $logicReport = new LogicReport($cn, $sqlBuilder, $_REQUEST);
                $logicReport->Event = $event;
                $logicReport->PageEvent = $pageEvent;
                $logicReport->tableDef = $tableDef;
                $html .= $logicReport->createReport($tableId, $pageOffset);
            } else {
                $logicForm = new LogicForm($cn, $sqlBuilder);
                $logicForm->Event = $event;
                $logicForm->PageEvent = $pageEvent;
                $logicForm->tableDef = $tableDef;
                $html .= $logicForm->createForm($tableId, $id);
            }

            // Add buttons to form
            $sqlBuilder->setTable($tableId);            
            $html .= $eventAction->createButton($pageEvent, $format);

            // Add global functions (js code)
            $html .= $eventAction->createJS();

            // Create form/load events
            $onLoadFunctions = $eventAction->createFormLoad($pageEvent, $format);
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