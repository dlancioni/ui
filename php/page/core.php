<?php

    // General declaration      
    $id = 0;
    $format = 1;
    //$moduleId = 0;

    $html = "";
    $error = "";
    $logicTable = "";
    $logicForm = "";
    $logicTabbed = "";
    $onLoadFunctions = "";

    $events = array();
    $base = new Base();
    
    try {
        
        // Handle request outside to organize code
        include "request.php";

        // Create table or form
        if ($moduleId > 0) {

            // Create main page
            switch ($format) {

                // Table
                case 1:
                    $logicTable = new LogicTable($cn, $sqlBuilder, $_REQUEST);
                    $logicTable->queryType = $sqlBuilder->QUERY;                    
                    $html .= $logicTable->createReport($moduleId, $viewId, $event, $pageOffset);
                    $error = $logicTable->getError();                    
                    break;

                 // Form    
                case 2:
                    $logicForm = new LogicForm($cn, $sqlBuilder);
                    $html .= $logicForm->createForm($moduleId, $id, $event);
                    $error = $logicForm->getError();
                    break;
                // Tabbed
                case 3:
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