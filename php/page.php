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

        // Create page or form
        $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $languageId);
        $element = new HTMLElement($cn, $sqlBuilder);        

        if ($tableId > 0) {
            if ($format == 1) {
                $report = new Report($cn, $sqlBuilder);
                $html .= $report->createReport($tableId, $event, $_REQUEST);
            } else {
                $form = new Form($cn, $sqlBuilder);
                $html .= $form->createForm($tableId, $id, $event);
            }
        }

        // Get events (buttons)
        $html .= $element->createEvent($tableId, $format);

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

?>