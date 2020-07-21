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

    if (valueOf("_EVENT_") == "filter") {
        go(valueOf("_TABLE_"), 1, valueOf("_EVENT_"));
    } else {
        let httpService = new HTTPService();
        info = httpService.persist(getFormData());
        alert(info);
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