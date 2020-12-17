<?php

    // General declaration      
    $id = 0;
    $logicReport = "";
    $logicForm = "";
    $logicTabbed = "";
    $moduleId = 0;  
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
        if ($moduleId > 0) {

            // Create main page
            switch ($format) {

                // Single table
                case $TABLE:
                    $logicReport = new LogicReport($cn, $sqlBuilder, $_REQUEST);
                    $logicReport->queryType = $sqlBuilder->QUERY;                    
                    $html .= $logicReport->createReport($moduleId, $viewId, $action, $pageOffset);
                    $error = $logicReport->getError();                    
                    break;

                // Single form    
                case $FORM:
                    $logicForm = new LogicForm($cn, $sqlBuilder);
                    $html .= $logicForm->createForm($moduleId, $id, $action);
                    $error = $logicForm->getError();
                    break;

                // Form with many tables (tabbed)    
                case $TABBED:
                    $logicTabbed = new LogicTabbed($cn, $sqlBuilder);
                    $html .= $logicTabbed->createTabbed($cn, $moduleId, $id);
                    $error = $logicTabbed->getError();
                    break;
            }

            // Handle error
            if ($error != "") {
                $html = $element->getAlert("Erro de processamento", $error);
            } else {
                $sqlBuilder->setModule($moduleId);
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