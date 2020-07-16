<?php
    // Include classes
    include "include.php";

    // General declaration
    $html = "";
    $menu = new Menu();
    $report = "";
    $form = "";
    $button = "";
    $style = 1;
    $id = 0;
    $tableId = 0;

    // Core code
    try {

        // Handle requests
        if (isset($_REQUEST["table"])) 
            $tableId = $_REQUEST["table"];        
        if (isset($_REQUEST["style"])) 
            $page = $_REQUEST["style"];
        if (isset($_REQUEST["selection"])) 
            $id = intval($_REQUEST['selection']);        

        // Get menu    
        $html .= $menu->createMenu();

        // Render page
        if ($tableId > 0) {
            if ($style == 1) {
                $table = new Table(1, $tableId, 1, 1);
                $html .= $table->createTable($tableId);
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