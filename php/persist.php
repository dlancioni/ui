<?php
    // Include classes
    include "include.php";

    // General declaration
    $output = $_REQUEST["name"];

    // Core code
    try {

    } catch (Exception $ex) {        
        $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
    } finally {

    }

    echo $output;
?>