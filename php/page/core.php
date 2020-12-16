<?php

    // General declaration      
    $id = 0;
    $logicReport = "";
    $logicForm = "";
    $logicTabbed = "";
    $tableId = 0;  
    $format = 1;
    $html = "";
    $onLoadFunctions = "";
    $error = "";
    $parent = array();
    $parentField = "";

    // Screen formats
    $TABLE = 1;
    $FORM = 2;
    $TABBED = 3;
    
    try {
        
        // Handle request outside to organize code
        include "request.php";

        // Create table or form
        if ($tableId > 0) {

            // Create main page
            switch ($format) {

                // Single table
                case $TABLE:
                    $logicReport = new LogicReport($cn, $sqlBuilder, $_REQUEST);
                    $html .= $logicReport->createReport($tableId, $viewId, $action, $pageOffset);
                    $error = $logicReport->getError();                    
                    break;

                // Single form    
                case $FORM:
                    $logicForm = new LogicForm($cn, $sqlBuilder);
                    $html .= $logicForm->createForm($tableId, $id, $action);
                    $error = $logicForm->getError();
                    break;

                // Form with many tables (tabbed)    
                case $TABBED:
                    $logicTabbed = new LogicTabbed($cn, $sqlBuilder);
                    $html .= $logicTabbed->createTabbed($cn, $tableId, $id);
                    $error = $logicTabbed->getError();
                    break;
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
        $html = $ex->getMessage();
    }

    // Close connection
    if ($cn) {
        pg_close($cn); 
    }    
?>