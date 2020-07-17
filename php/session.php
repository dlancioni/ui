
<?php

    // Disable caches at all
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // Start session
    session_start();

    // General Declaration
    $systemId = 0; 
    $tableId = 0; 
    $userId = 0; 
    $languageId = 0;
    $filter = "[]";    

    // Session attributes    
    $_SESSION["_SYSTEM_"] = 1;
    $_SESSION['_TABLE_'] = 2;
    $_SESSION['_USER_'] = 1;
    $_SESSION['_LANGUAGE_'] = 1;
    $_SESSION['_ID_'] = 0;

    // Solution allow multiple systems
    if (isset($_SESSION["_SYSTEM_"])) {
        $systemId = $_SESSION["_SYSTEM_"];
    }

    // Current module
    if (isset($_SESSION["_TABLE_"])) {
        $tableId = $_SESSION["_TABLE_"];
    }

    // Current user
    if (isset($_SESSION["_USER_"])) {
        $userId = $_SESSION["_USER_"];
    }

    // Current language
    if (isset($_SESSION["_LANGUAGE_"])) {
        $languageId = $_SESSION["_LANGUAGE_"];
    }

    // Selected record on current module 
    if (isset($_SESSION["_ID_"])) {
        $languageId = $_SESSION["_ID_"];
    }    

?>
