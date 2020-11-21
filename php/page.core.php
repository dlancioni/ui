<?php

    // General declaration      
    $id = 0;
    $logicReport = "";
    $logicForm = "";
    $tableId = 0;  
    $format = 1;
    $html = "";
    $onLoadFunctions = "";
    $error = "";
    
    try {
        
        // Handle request outside to organize code
        include "page.request.php";

        // Create table or form
        if ($tableId > 0) {

            // Go to current table
            $sqlBuilder->setTable($tableId);

            // Create page or form
            if ($format == 1) {
                $logicReport = new LogicReport($cn, $sqlBuilder, $_REQUEST);
                $logicReport->action = $action;
                $logicReport->PageEvent = $pageEvent;
                $logicReport->tableDef = $tableDef;
                $logicReport->viewDef = $viewDef;
                $html .= $logicReport->createReport($tableId, $viewId, $pageOffset);
                $error = $logicReport->getError();                
            } else {
                $logicForm = new LogicForm($cn, $sqlBuilder);
                $logicForm->action = $action;
                $logicForm->PageEvent = $pageEvent;
                $logicForm->tableDef = $tableDef;
                $html .= $logicForm->createForm($tableId, $id);
                $error = $logicForm->getError();
            }

            // Handle error
            if ($error != "") {

                // Alert the final error
                $html = $element->getAlert("Erro de processamento", $error);

            } else {

                // Back to main table
                $sqlBuilder->setTable($tableId);

                // Add buttons to form
                $html .= $eventAction->createButton($pageEvent, $format);

                // Add global functions (js code)
                $html .= $eventAction->createJS();

                // Create form/load events
                $onLoadFunctions = $eventAction->createFormLoad($pageEvent, $format);
            }
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