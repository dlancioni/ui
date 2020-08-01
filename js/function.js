/*
 * Navigate to page in table or form format
 */
function go(table=0, format=1, event="") {
    document.getElementById("_TABLE_").value = table;
    document.getElementById("_FORMAT_").value = format;
    document.getElementById("_EVENT_").value = event;
    document.form1.submit();
}

/*
 * Save current form
 */
function confirm() {

    let info = "";

    if (valueOf("_EVENT_") == "Filter") {
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
    return document.getElementById(element).value;
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
    let form = document.getElementById('form1');
    form.reset();
}

/*
 * Set focus on current field
 */
function setFocus(fieldName) {  
    document.getElementById(fieldName).focus();
}

/*
 * Validate mandatory fields
 */
function isMandatory(fieldName, fieldLabel, message) {  

    if(valueOf(fieldName) == '') {
        alert(message);
        setFocus(fieldName);
        return false;
    }
    return true;
}



function validateForm() {

    if (!isMandatory('name', 'Name', 'Campo Name eh obrigatorio')) {
        return false;
    }

    if (!isMandatory('expire_date', 'Expire Date', 'Campo Expire Date eh obrigatorio')) {
        return false;
    }

    return true;
}