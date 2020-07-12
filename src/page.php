<?php
    // Include classes
    include "include.php";

    // General declaration
    $menu = "";
    $report = "";
    $form = "";
    $button = "";

    // Core code
    try {

        $form = new Form(1,2,1,1);
        echo $form->createForm(1);


    } catch (Exception $ex) {        
        $data = '{"status":"fail", "error":' . $ex->getMessage() . '}';
    } finally {

    }

?>