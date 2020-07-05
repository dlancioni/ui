<?php
    include "../src/exception.php";
    include "../src/base.php";
    include "../src/db.php";
    include "../src/sqlbuilder.php";

    $sqlBuilder = new SqlBuilder(1, 3, 1, 1);
    echo $sqlBuilder->query("");
?>