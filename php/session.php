
<?php
    session_start();

 

    $_SESSION['id_system'] = 1;
    $_SESSION['id_table'] = 2;
    $_SESSION['id_user'] = 1;
    $_SESSION['id_language'] = 1;

    $systemId = 0; 
    $tableId = 0; 
    $userId = 0; 
    $languageId = 0;
    $filter = "[]";

    if (isset($_SESSION['id_system']))
        $systemId = $_SESSION['id_system'];
    if (isset($_SESSION['id_table']))
        $tableId = $_SESSION['id_table'];
    if (isset($_SESSION['id_user']))
        $userId = $_SESSION['id_user'];
    if (isset($_SESSION['id_language']))
        $languageId = $_SESSION['id_language'];


?>
