<?php
    include "../src/db.php";
    $db = new Db();
    
    if ($_REQUEST["param"] == "struct") {
        $sql = "select * from vw_table where id_table = 4";
    } else {
        $sql = "select field from tb_field where field->'id_table' = '2'";
    }

    $resultset = $db->query($sql);   
    while ($row = pg_fetch_row($resultset)) {
        echo $row[0];
    }
?>