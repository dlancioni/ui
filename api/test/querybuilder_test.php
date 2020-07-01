<?php
    include "../src/base.php";
    include "../src/db.php";
    include "../src/querybuilder.php";

    $queryBuilder = new QueryBuilder(1, 3, 1, 1);
    $rs = $queryBuilder->getTableDef(1,3);

    while ($row = pg_fetch_row($rs)) {
        echo $row[3];
    }
?>