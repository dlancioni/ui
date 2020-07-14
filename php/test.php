<?php

include "../src/class_util.php";

$filter = new Filter();

$filter->add("tb1", "id", "0");

echo $filter->create();


?>