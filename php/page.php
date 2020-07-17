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
        $menu = new Menu();

        // Open connection
        $cn = $db->getConnection();        

        // Get menu    
        $html .= $menu->createMenu();

        // Render page
        if ($tableId > 0) {
            if ($format == 1) {
                $report = new Table($systemId, $tableId, $userId, $languageId);
                $html .= $report->createTable($cn, $tableId);
            } else {
                $form = new Form($systemId, $tableId, $userId, $languageId);
                $html .= $form->createForm($cn, $tableId, $id);
            }
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

?>