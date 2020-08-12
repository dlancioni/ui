<?php

$tb1 = 1;
$tb2 = 2;

$age[$tb1] = "David";
$age[$tb2] = "Renata";

echo var_dump($age);

$age[$tb2] = "Taza";
echo var_dump($age);

?>


<script>

let filter = 
[
    {"table":"tb_table", "field":"id", "type":"int", "operator":"=", "value":"123", "mask":""}
]
filter.push({"table":"tb_table", "field":"id", "type":"int", "operator":"=", "value":"123", "mask":""});
//alert(filter.length);
//alert(JSON.stringify(filter))

</script>