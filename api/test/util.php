<?php
    include "../src/util.php";
    
    $table = "tb_field";
    $field = "name";
    $type = "text";
    $alias = "name_field";
    $operator = "=";
    $value = "David";

    $jsonUtil = new JsonUtil();
    echo $jsonUtil->field("tb", "id", "int");
    echo "<br><br>";
    echo $jsonUtil->field("tb_system", "expire_date", "date", "dd/mm/yyyy");
    echo "<br><br>";
    echo $jsonUtil->condition("tb_system", "expire_date", "date", "=", "31/12/2020", "dd/mm/yyyy");
    echo "<br><br>";
    echo $jsonUtil->condition("tb_system", "code", "int", "=", "2020");

    /*
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
    */


    //echo $jsonUtil->jfield($table, $field, $type);
    //echo $jsonUtil->jsel($table, $field, $type, $alias);
    //echo $jsonUtil->condition($table, $field, $type, $operator, $value);
    //echo $jsonUtil->join("tb_cliente", "id_pedido", "tbped", "tb_pedido", "id");
    //echo $jsonUtil->join("tb_cliente", "id_pedido", "tbped", "tb_pedido", "id","tb_domain");

?>