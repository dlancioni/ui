<?php

?>


<script>

let filter = 
[
    {"table":"tb_table", "field":"id", "type":"int", "operator":"=", "value":"123", "mask":""}
]

filter.push({"table":"tb_table", "field":"id", "type":"int", "operator":"=", "value":"123", "mask":""});

alert(filter.length);
alert(JSON.stringify(filter))

</script>