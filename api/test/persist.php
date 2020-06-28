<?php
    include "../src/db.php";
    include "../src/base.php";
    include "../src/persist.php";

    $persist = new Persist(1, 2, 3, 4);

    echo $persist->getSystem();
    echo $persist->getTable();
    echo $persist->message();

?>