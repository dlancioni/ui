<?php

    // General declaration      
    $id = 0;
    $format = 1;
    $moduleId = 0;

    $html = "";
    $error = "";
    $logicTable = "";
    $logicForm = "";
    $logicTabbed = "";
    $onLoadFunctions = "";

    // Screen formats
    $TABLE = 1;
    $FORM = 2;
    $TABBED = 3;
    $events = array();    
    
    try {
        
        // Handle request outside to organize code
        include "request.php";

        // Create table or form
        if ($moduleId > 0) {

            // Create main page
            switch ($format) {

                // Single table
                case $TABLE:
                    $logicTable = new LogicTable($cn, $sqlBuilder, $_REQUEST);
                    $logicTable->queryType = $sqlBuilder->QUERY;                    
                    $html .= $logicTable->createReport($moduleId, $viewId, $event, $pageOffset);
                    $error = $logicTable->getError();                    
                    break;

                // Single form    
                case $FORM:
                    $logicForm = new LogicForm($cn, $sqlBuilder);
                    $html .= $logicForm->createForm($moduleId, $id, $event);
                    $error = $logicForm->getError();
                    break;

                // Form with many tables (tabbed)    
                case $TABBED:
                    $logicTabbed = new LogicTabbed($cn, $sqlBuilder);
                    $html .= $logicTabbed->createTabbed($cn, $moduleId, $id);
                    $error = $logicTabbed->getError();
                    break;
            }

            // Get load events
            $onLoadFunctions = $eventAction->createFormLoad($moduleId, $format);

            // Handle error
            if ($error != "") {
                $html = $element->getAlert("Erro de processamento", $error);
            } else {
                $sqlBuilder->setModule($moduleId);
                $html .= $eventAction->createJS();
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