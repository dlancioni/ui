<?php
    include "../src/db.php";
    $db = new Db();
    
    $sql = "select field from tb_table";
    $resultset = $db->query($sql);   
    while ($row = pg_fetch_row($resultset)) {
        echo $row[0];
    }
?>