<?php
    include "../src/exception.php";
    include "../src/db.php";
    include "../src/base.php";
    include "../src/persist.php";

    // Test constructor inherance
    function constructor_test() {
        $persist = new Persist(1, 2, 3, 4);
        echo $persist->getSystem();
        echo $persist->getTable();
        echo $persist->getUser();
        echo $persist->getLanguage();
    }
    //constructor_test();

    // Test constructor inherance
    function insert_test() {

        $persist = new Persist(0,0,0,0);
        $persist->insert();

        if ($persist->getError() != "") {
            echo $persist->getError();
        } else {
            echo $persist->getLastId();
        }


    }
    insert_test();

?>