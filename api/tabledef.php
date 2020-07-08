<?php
    // Handle Exceptions 
    include "exception.php";
    include "util.php";
    include "base.php";
    include "db.php";
    include "sqlbuilder.php";

    // http://localhost/ui/api/tabledef.php?system=1&table=3
    
    // General Declaration
    $db = "";
    $conn = "";
    $data = "";
    $systemId = $_REQUEST["system"];
    $tableId = $_REQUEST["table"];
    $userId = 1;
    $languageId = 1;

    // Core code
    try {
        $db = new Db();
        $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $languageId);
        $data = $sqlBuilder->getTableDef("json");
    } catch (Exception $ex) {
        $data = '{"status":"fail", "error":' . $ex.getMessage() . '}';
    }

    // Output data
    if (!$data) {
        $data = "[]";
    }

    // Return data
    echo $data;
?>