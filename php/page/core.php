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
    $parent = array();
    $parentField = "";
    
    try {
        
        // Handle request outside to organize code
        include "request.php";

        // Keep parent modules
        $parent = getParent($cn, $sqlBuilder, $tableId);
        if (count($parent) > 0) {
            $parentField = str_replace("tb_", "id_", $parent[0]["name"]);
        }

        // Create table or form
        if ($tableId > 0) {

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
        $html = $ex->getMessage();
    }

    // Close connection
    if ($cn) {
        pg_close($cn); 
    }    

    /*
     * Get parent module to mount tabbed effect
     */
    function getParent($cn, $sqlBuilder, $tableId) {

        $viewId = 0;
        $filter = "";
        $data = "";

        try {

            // Get data
            $filter = new Filter();
            $filter->add("tb_table", "id_parent", $tableId);
            $data = $sqlBuilder->executeQuery($cn, $sqlBuilder->TB_TABLE, $viewId, $filter->create());

        } catch (Exception $ex) {        
            throw $ex;
        }

        // Return it
        return $data;

    }



?>