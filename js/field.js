
/*
 * Validate table name
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

/*
 * Read form and return array
 */
function getFormData() {
    
    // Read form
    let form = document.getElementById('form1');
    let formData = new FormData(form);

    // Append upload related fields        
    var input = document.querySelector('input[type="file"]')         
    if (input != null) {
        for (let file of input.files) {
            formData.append('file', file, file.name)
        }
    }

    // Just return it
    return formData;
}

/*
 * Return field object
 */
function field(element) {
    return document.getElementById(element);
}

/*
 * Cascade drop down
 */
async function cascade(fieldTarget, fieldName, fieldValue, tableName, id, ds) {

    let url = "";
    let data = "";
    let page = 'async/dropdown.php';
    let formData = new FormData();
    let dropdown = document.getElementById(fieldTarget);
    let option = document.createElement("option");

    // Set commands to end session
    formData.append('fieldName', fieldName);
    formData.append('fieldValue', fieldValue);
    formData.append('tableName', tableName);
    formData.append('id', id);
    formData.append('ds', ds);
    data = await execute(page, formData);

    if (data != "") {

        // Clear target dropdown
        dropdown.innerText = null;

        // Convert json to array
        let options = JSON.parse(data);

        // Populate dropdown
        for (let i=0; i<=options.length-1; i++) {            
            option = document.createElement("option");
            option.value = options[i].key;
            option.text = options[i].value;
            dropdown.add(option);
        }
    }

}



/*
 * Remove , or . 
 */
function valueOf(value) {

    value = value.toString();

    if (value.trim() == "") {
        value = "0";
    }

    if (!parseFloat(value)) {
        value = "0";
    }

    value = value.split('.').join('');
    value = value.split(',').join('.');        
    value = parseFloat(value);

    return value;
}

/*
 * Clear options
 */
function optionClear(field) {
    dropdown = document.getElementById(field);
    dropdown.innerText = null;
    option = document.createElement("option");
    option.value = "0";
    option.text = "Selecionar";
    dropdown.add(option);
}

