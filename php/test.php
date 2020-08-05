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
    let arr = [];
    let output = "";
    let pattern = /[A-Za-z0-9_]/g; 

    // If has value
    if (value.trim() != "") {

        // Test pattern        
        arr = value.match(pattern);

        if (arr == null) 
            return "";

        // Array to string
        for (let i=0; i<=arr.length-1; i++) {
            output += arr[i];
        }
    }

    // Just return
    return output.trim();
}

</script>