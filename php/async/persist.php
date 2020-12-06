<?php
    // Start session
    session_start();

    // Include classes
    include "../page/include.php";

    // General declaration
    $json = "";
    $persist = new Persist();

    try {

        // Save current record
        $json = $persist->save($_SESSION);

    } catch (Exception $ex) {

        // Error handling
        $json = $message->getStatus(2, $ex->getMessage());
    }

    // Return results
    echo $json;
?>