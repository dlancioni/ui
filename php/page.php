<?php
    // Include classes
    include "include.php";

    // General declaration      
    $id = 0;
    $report = "";
    $form = "";
    $tableId = 0;  
    $format = 1;
    $html = "";      
    $event = "";
    
    $menu = new Menu();

    // Core code
    try {

        // Handle request outside to organize code
        include "request.php";

        // Get menu    
        $html .= $menu->createMenu();

        // Render page
        if ($tableId > 0) {
            if ($format == 1) {
                $report = new Table(1, $tableId, 1, 1);
                $html .= $report->createTable($tableId);
            } else {
                $form = new Form(1, $tableId, 1, 1);
                $html .= $form->createForm($tableId);
            }
        }


    } catch (Exception $ex) {        
        $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
    } finally {

    }

    echo $html;

?>