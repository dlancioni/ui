<?php
    // Include classes
    include "include.php";

    // General declaration
    $output = "Primeiro teste";

    // Core code
    try {

    } catch (Exception $ex) {        
        $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
    } finally {

    }

    echo $output;
?>