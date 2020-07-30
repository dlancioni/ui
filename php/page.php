<?php
    // Include classes
    include "include.php";

    // General declaration      
    $id = 0;
    $db = "";
    $cn = "";
    $report = "";
    $form = "";
    $tableId = 0;  
    $format = 1;
    $html = "";      
    $event = "";
    $menu = "";
    $pageEvent = "";
    $TB_EVENT = 5;
    $element = "";

    try {
        
        // Handle request outside to organize code
        include "request.php";

        // Create objects
        $db = new Db();
        $cn = $db->getConnection();

        // Get menu    
        $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $languageId);        
        $menu = new Menu($cn, $sqlBuilder);
        $html .= $menu->createMenu();

        // Get events
        $filter = new Filter();
        $filter->add("tb_event", "id_target", $format);
        $filter->add("tb_event", "id_table", $tableId);
        $pageEvent = $sqlBuilder->Query($cn, $TB_EVENT, $filter->create());

        // Create table or form
        if ($tableId > 0) {

            // Create page or form
            $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $languageId);
            $element = new HTMLElement($cn, $sqlBuilder);        

            if ($format == 1) {
                $report = new Report($cn, $sqlBuilder);
                $html .= $report->createReport($tableId, $event, $pageOffset, $_REQUEST, $pageEvent);
            } else {
                $form = new Form($cn, $sqlBuilder);
                $html .= $form->createForm($tableId, $id, $event, $pageEvent);
            }

            // Add buttons to form
            $html .= CreateButton($pageEvent);
        }

    } catch (Exception $ex) {        
        
        // Error handler
        $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';

    } finally {

        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }

    echo $html;

    /* 
     * Get event list and isolate function calls related to buttons
     */
    function CreateButton($pageEvent) {

        // General declaration
        $html = "";
        global $element;

        // Space between form and buttons
        $html = "<br><br>";

        // Create event list
        foreach ($pageEvent as $item) {
            $html .= $element->createButton($item["name"], $item["label"], $item["event"], $item["code"]);
        }
        
        // Return to main function
        return $html;
    }


?>