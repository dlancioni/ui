<?php
    include "../src/db.php";
    include "../src/base.php";
    $base = new Base(0, 0, 0, 0);

    echo "Base:" . "<br>";

    $base->setSystem(1); 
    echo $base->getSystem() . "<br>";

    $base->setTable(2); 
    echo $base->getTable() . "<br>";

    $base->setUser(3); 
    echo $base->getUser() . "<br>";

    $base->setLanguage(4); 
    echo $base->getLanguage() . "<br>";
?>