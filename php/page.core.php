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
                $html .= $logicReport->createReport($tableId, $viewId, $action, $pageOffset);
                $error = $logicReport->getError();
            } else {
                $logicForm = new LogicForm($cn, $sqlBuilder);
                $html .= $logicForm->createForm($tableId, $id, $action);
                $error = $logicForm->getError();
            }

            // Handle error
            if ($error != "") {
                $html = $element->getAlert("Erro de processamento", $error);
            } else {
                $sqlBuilder->setTable($tableId);
                $html .= $eventAction->createJS();
                //$onLoadFunctions = $eventAction->createFormLoad($pageEvent, $format);
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