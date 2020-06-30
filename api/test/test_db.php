<?php

    include "../src/exception.php";
    include "../src/base.php";
    include "../src/db.php";

    $db = new Db();   
    $db->persist();

    if ($db->getError() != "") {
        echo $db->getError();
    } else {
        echo $db->getLastId();
    }

?>