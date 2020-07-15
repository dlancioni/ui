<?php
    // Include classes
    include "include.php";

    // General declaration
    $menu = "";
    $report = "";
    $form = "";
    $button = "";
    $page = 1;
    $id = 0;

    // Core code
    try {

        // Handle requests
        if (isset($_REQUEST["page"])) 
            $page = $_REQUEST["page"];
        if (isset($_REQUEST["selection"])) 
            $id = intval($_REQUEST['selection']);        

        // Render page
        if ($page == 1) {
            $button = '<br><input type="button" value="Form" onClick="go(2);">';
            $table = new Table(1,2,1,1);
            echo $table->createTable(1) . $button;
        } else {
            $button = '<br><input type="button" value="Table" onClick="go(1);">';
            $form = new Form(1,2,1,1);
            echo $form->createForm(1) . $button;
        }

    } catch (Exception $ex) {        
        $data = '{"status":"fail", "error":' . $ex->getMessage() . '}';
    } finally {

    }

?>