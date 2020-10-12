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
    $menu = "";
    $logicMenu = "";
    $onLoadFunctions = "";
    
    try {
        
        // Handle request outside to organize code
        include "request.php";

        // Get main menu    
        $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $groupId);

        // First step, authentication
        $logicAuth = new LogicAuth($cn, $sqlBuilder);
        $logicAuth->authenticate($signId, $username, $password);

        if ($logicAuth->authenticated == 1) {
            $_SESSION["_AUTH_"] = 1;
            $userId = $logicAuth->userId;
            $_SESSION['_USER_'] = $userId;
            $groupId = $logicAuth->groupId;
            $_SESSION['_GROUP_'] = 2;
        } else {
            echo $logicAuth->error;
        }

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

        // If usre is authenticated, create main menu
        if ($_SESSION["_AUTH_"] == 1) {
            $logicMenu->createMenu($systemId, $userId);
            $menu = $logicMenu->html;
        }

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

    } finally {

        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }

?>