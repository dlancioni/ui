
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
    let form = document.getElementById('form1');
    let fd = new FormData(form);
    alert(fd);
    let formData = new URLSearchParams(fd).toString();
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
function cascade(fieldTarget, fieldName, fieldValue, tableName, id, ds) {

    let url = "";
    let data = "";
    let dropdown = document.getElementById(fieldTarget);
    let option = document.createElement("option");

    url += "dropdown.php";
    url += "?fieldName=" + fieldName;
    url += "&fieldValue=" + fieldValue;
    url += "&tableName=" + tableName;
    url += "&id=" + id;
    url += "&ds=" + ds;

    let httpService = new HTTPService();
    data = httpService.execute(url);

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

