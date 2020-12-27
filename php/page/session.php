
<?php

    // Disable caches at all
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // Start session
    session_start();

    // General Declaration
    $systemId = 0; 
    $moduleId = 0; 
    $viewId = 0;    
    $userId = 0;
    $groupId = 0; 
    $pageOffset = 0;
    $event = 0;
    $username = "";
    $password = "";    
    $filter = array();
    $eventAction = array();
    $element = array();
    $viewList = array();

    // Solution allow multiple systems
    if (isset($_SESSION["_SYSTEM_"])) {
        $systemId = $_SESSION["_SYSTEM_"];
    }

    // Current table
    if (isset($_SESSION["_MODULE_"])) {
        $moduleId = intval($_SESSION["_MODULE_"]);
    }

    // Current view
    if (isset($_SESSION["_VIEW_"])) {
        $viewId = intval($_SESSION["_VIEW_"]);
    }

    // Current user
    if (isset($_SESSION["_USER_"])) {
        $userId = intval($_SESSION["_USER_"]);
    }

    // Current group
    if (isset($_SESSION["_GROUP_"])) {
        $groupId = intval($_SESSION["_GROUP_"]);
    }

    // Current group
    if (isset($_SESSION["_USERNAME_"])) {
        $username = $_SESSION["_USERNAME_"];
    }

    // Get connection
    $db = new Db();
    $cn = $db->getConnection($systemId);

    // Get main components
    $sqlBuilder = new SqlBuilder($systemId, $moduleId, $userId, $groupId);
    $eventAction = new EventAction($cn);
    $logicMenu = new LogicMenu($cn);
    $element = new HTMLElement($cn);
    
?>
