<?php
    // Handle Exceptions 
    include "exception.php";
    include "util.php";
    include "base.php";
    include "db.php";
    include "sqlbuilder.php";

    // http://localhost/ui/api/query.php?system=1&table=3&user=1&language=1
    // http://localhost/ui/api/query.php?system=1&user=1&language=1&table=3

    // General Declaration
    $db = "";
    $conn = "";
    $data = "";

    $systemId = $_REQUEST["system"];
    $tableId = $_REQUEST["table"];
    $userId = $_REQUEST["user"];
    $languageId = $_REQUEST["language"];

    // Core code
    try {
        $db = new Db();
        $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $languageId);
        $sql = $sqlBuilder->getQuery("");
        $data = $db->queryJson($sql);
    } catch (Exception $ex) {
        $data = '{"status":"fail", "error":' . $ex.getMessage() . '}';
    }

    // Output data
    echo $data;
?>