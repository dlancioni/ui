/*
 * Navigate to page in table or form format
 */
function go(table=0, format=1, event="") {
    document.getElementById("_TABLE_").value = table;
    document.getElementById("_FORMAT_").value = format;
    document.getElementById("_EVENT_").value = event;
    document.getElementById("_PAGING_").value = 0;
    document.form1.submit();
}

/*
 * Save current form
 */
function confirm() {

    let info = "";

    if (valueOf("_EVENT_") == "Filter") {
        field("_PAGING_").value = 0;
        go(valueOf("_TABLE_"), 1, valueOf("_EVENT_"));
    } else {
        let httpService = new HTTPService();
        if (validateForm()) {
            info = httpService.persist(getFormData());        
            alert(info);            
        }
    }
}

/*
 * Read form and return array
 */
function getFormData() {
    let form = document.getElementById('form1');
    let formData = new URLSearchParams(new FormData(form)).toString();
    return formData;
}

/*
 * Read html element
 */
function valueOf(element) {
    return document.getElementById(element).value.trim();
}

/*
 * Return field object
 */
function field(element) {
    return document.getElementById(element);
}

/*
 * Concatenate single quote ('')
 */
function sqt(value) {
    return "'" + value.trim() + "'";
}

/*
 * Concatenate single quote ('')
 */
function query(sql) {
    let httpService = new HTTPService();
    info = httpService.query(sql);
    return info;
}

/*
 * Empty form to input new record
 */
function formNew() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "New";
    document.form1.submit();
}
function formEdit() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "Edit";
    document.form1.submit();
}
function formDelete() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "Delete";
    document.form1.submit();
}
function formFilter() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "Filter";
    document.form1.submit();
}
function reportBack() {
    document.getElementById("_FORMAT_").value = 1;
    document.getElementById("_EVENT_").value = 'Back';
    document.form1.submit();
}

/*
 * Paging effect
 */
function paging(pageOffset) {
    document.getElementById("_PAGING_").value = pageOffset;
    document.form1.submit();
}

/*
 * Cascade drop down
 */
function cascade(value, source, target) {

    let url = "";
    let data = "";
    let dropdown = document.getElementById(target);
    let option = document.createElement("option");

    url += "dropdown.php";
    url += "?value=" + value;    
    url += "&source=" + source;
    url += "&target=" + target;

    let httpService = new HTTPService();
    data = httpService.query(url);

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
 * Clear form
 */
function formClear() {
    
    let elements = "";

    // Clear text
    elements = document.querySelectorAll("input[type=text]")
    for (let i=0, element; element=elements[i++];) {
        if (element.name != "id") {
            element.value = "";
        }
    }

    // Clear dropdown
    elements = document.querySelectorAll("select")
    for (let i=0, element; element=elements[i++];) {
        if (element.name != "id") {        
            element.value = 0;
        }
    }

    // Clear textarea    
    elements = document.querySelectorAll("textarea")
    for (let i=0, element; element=elements[i++];) {
        if (element.name != "id") {
            element.value = "";
        }
    }    

}

/*
 * Validate mandatory fields
 */
function isMandatory(fieldName, message, fk) {

    if (fk == 0) {
        if(valueOf(fieldName) == '') {
            alert(message);
            field(fieldName).focus();
            return false;
        }
    } else {
        if(valueOf(fieldName) == 0) {
            alert(message);
            field(fieldName).focus();
            return false;
        }
    }

    return true;
}

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