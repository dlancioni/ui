
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
    $groupId = 0; 
    $filter = "[]"; 
    $pageOffset = 0;

    // Get connection
    $db = new Db();
    $cn = $db->getConnection();    

    // Filter for current table
    //$_SESSION["_FILTER_"] = [];
    $_SESSION["_AUTH_"] = 1;

    // Key attributes    
    $_SESSION["_SYSTEM_"] = 1;
    $_SESSION['_TABLE_'] = 2;
    $_SESSION['_USER_'] = 1;
    $_SESSION['_GROUP_'] = 2;
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

    // Current group
    if (isset($_SESSION["_GROUP_"])) {
        $groupId = $_SESSION["_GROUP_"];
    }
    
?>
