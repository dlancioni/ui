/*
 * Navigate to page in table or form format
 */
function Go(table=0, format=1, event="") {
    document.getElementById("_TABLE_").value = table;
    document.getElementById("_FORMAT_").value = format;
    document.getElementById("_EVENT_").value = event;
    document.form1.submit();
}

/*
 * Save current form
 */
function Confirm() {

    let info = "";

    if (ValueOf("_EVENT_") == "Filter") {
        Go(ValueOf("_TABLE_"), 1, ValueOf("_EVENT_"));
    } else {
        let httpService = new HTTPService();
        info = httpService.persist(GetFormData());
        alert(info);
    }
}

/*
 * Read form and return array
 */
function GetFormData() {
    let form = document.getElementById('form1');
    let formData = new URLSearchParams(new FormData(form)).toString();
    return formData;
}

/*
 * Read html element
 */
function ValueOf(element) {
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
function FormNew() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "New";
    document.form1.submit();
}
function FormEdit() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "Edit";
    document.form1.submit();
}
function FormDelete() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "Delete";
    document.form1.submit();
}
function FormFilter() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "Filter";
    document.form1.submit();
}
function ReportBack() {
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