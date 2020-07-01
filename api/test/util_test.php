<?php
    include "../src/util.php";
    
    $stringUtil = new StringUtil();
    echo "StringUtil:" . "<br>";
    echo $stringUtil->qt('  teste  ') . "<br>";

    $jsonUtil = new JsonUtil();
    echo "JsonUtil.setValue:" . "<br>";
    echo $jsonUtil->setValue('{"id":10}', 'id', 20) . "<br>";
    echo $jsonUtil->setValue('{"ds":""}', 'ds', 'Description') . "<br>";

    echo "JsonUtil.jfield:" . "<br>";
    echo $jsonUtil->jfield("tb", "field", 1) . "<br>";
    echo $jsonUtil->jfield("tb_field", "id_system", 1) . "<br>";
?>