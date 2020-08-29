/*
 * Navigate to page in table or form format
 */
function go(table=0, format=1, event="") {
    field("_TABLE_").value = table;
    field("_FORMAT_").value = format;
    field("_EVENT_").value = event;
    field("_PAGING_").value = 0;
    submit();
}

/*
 * Submit current form
 */
function submit(param="form1") {
    form = document.getElementById(param);
    form.submit();
}

/*
 * Save current form
 */
function confirm() {
    let info = "";
    let httpService = "";
    if (field("_EVENT_").value == "Filter") {
        field("_PAGING_").value = 0;
        go(field("_TABLE_").value, 1, field("_EVENT_").value);
    } else {
        if (validateForm()) {
            httpService = new HTTPService();            
            info = httpService.persist(getFormData());        
            alert(info);      
            if (field("_EVENT_").value != "New") {
                reportBack();
            }
        }
    }
}

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
    let formData = new URLSearchParams(new FormData(form)).toString();
    return formData;
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
function query(sql) {
    let httpService = new HTTPService();
    info = httpService.query(sql);
    return info;
}

/*
 * Empty form to input new record
 */
function formNew() {
    field("_FORMAT_").value = 2;
    field("_EVENT_").value = "New";
    document.form1.submit();
}
function formEdit() {
    field("_FORMAT_").value = 2;
    field("_EVENT_").value = "Edit";
    document.form1.submit();
}
function formDelete() {
    field("_FORMAT_").value = 2;
    field("_EVENT_").value = "Delete";
    document.form1.submit();
}
function formFilter() {
    field("_FORMAT_").value = 2;
    field("_EVENT_").value = "Filter";
    document.form1.submit();
}
function reportBack() {
    field("_FORMAT_").value = 1;
    field("_EVENT_").value = 'Back';
    document.form1.submit();
}

/*
 * Paging effect
 */
function paging(pageOffset) {
    field("_PAGING_").value = pageOffset;
    submit();
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
function validateMandatory(fieldName, fk, message) {
    if (fk == 0) {
        if(field(fieldName).value == '') {
            alert(message);
            field(fieldName).focus();
            return false;
        }
    } else {
        if(field(fieldName).value == 0) {
            alert(message);
            field(fieldName).focus();
            return false;
        }
    }
    return true;
}

/*
 * Validate dates
 */
function validateDate(fieldName, mask, message="") {
    let dt = moment(field(fieldName).value, mask.toUpperCase(), true);
    if (dt.isValid()) {
        return true;
    } else {
        if (message != "") {
            alert(message);
            field(fieldName).focus();
        }
        return false;
    }
}

/*
 * Validate numerics
 */
function validateNumeric(fieldName, message="") {
    if (isNumeric(field(fieldName).value)) {
        return true;
    } else {
        if (message != "") {
            alert(message);
            field(fieldName).focus();
        }
        return false;
    }
}

/*
 * Remove , or . 
 */
function valueOf(value) {

    value = value.split('.').join('');
    value = value.split(',').join('.');        
    value = parseFloat(value);

    return value;
}

/*
 * Check if native value is numeric
 */
function isNumeric(value) {
    value = valueOf(value);    
    return !isNaN(parseFloat(value)) && isFinite(value);
}

/*
 * Format value
 */
function formatValue(value) {
    value = valueOf(value);
    let x = new Intl.NumberFormat("pt-BR", {minimumFractionDigits: 2}).format(value);
    return x;
}