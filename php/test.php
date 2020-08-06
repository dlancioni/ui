<?php

?>


<script>

let filter = 
[
    {"table":"tb_table", "field":"id", "type":"int", "operator":"=", "value":"123", "mask":""}
]
filter.push({"table":"tb_table", "field":"id", "type":"int", "operator":"=", "value":"123", "mask":""});
//alert(filter.length);
//alert(JSON.stringify(filter))

/*
 * Validate table name based on pattern
 */
function validateTableName(value) {

// Define patter
let output = "";
let pattern = /[A-Za-z0-9_]/g; 

// If has value
if (value.trim() != "") {
    output = value.match(pattern).toString().replace(/,/g, '');
}

// Just return
return output.trim();
}


alert(validateTableName("tb_[]1"));

</script>