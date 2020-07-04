<?php

$json = '[
            {"table":"tb_system", "field":"id_system", "type":"int", "operator":"=", "value":"1", "mask":""},
            {"table":"tb_system", "field":"id_system", "type":"int", "operator":"=", "value":"31/12/2020", "mask":"dd/mm/yyyy"}
]';


$filter = json_decode($json, true);

foreach($filter as $item) {
    echo $item['value'];
}

//echo var_dump($filter);

?>