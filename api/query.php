<?php
    // Handle Exceptions 
    include "exception.php";
    include "util.php";
    include "base.php";
    include "db.php";
    include "sqlbuilder.php";

    // http://localhost/ui/api/query.php?system=1&table=3&user=1&language=1&filter=
    // http://localhost/ui/api/query.php?system=1&user=1&language=1&table=3&filter=
    // http://localhost/ui/api/query.php?system=1&user=1&language=1&table=3&filter=[{%22table%22:%22tb_field%22,%22field%22:%22id_table%22,%22type%22:%22int%22,%22operator%22:%22=%22,%22value%22:3,%22mask%22:%22%22}]

    // General Declaration
    $db = "";
    $conn = "";
    $data = "";
    $filter = "";

    $systemId = $_REQUEST["system"];
    $tableId = $_REQUEST["table"];
    $userId = $_REQUEST["user"];
    $languageId = $_REQUEST["language"];
    $filter = $_REQUEST["filter"];

    // Core code
    try {
        $db = new Db();
        $sqlBuilder = new SqlBuilder($systemId, $tableId, $userId, $languageId);
        $sql = $sqlBuilder->getQuery($filter);        
        $data = $db->queryJson($sql);
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