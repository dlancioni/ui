<?php
    include "../src/exception.php";
    include "../src/base.php";
    include "../src/db.php";
    include "../src/querybuilder.php";

    $queryBuilder = new QueryBuilder(1, 3, 1, 1);
    echo $queryBuilder->query();


?>