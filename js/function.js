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

    if (ValueOf("_EVENT_") == "filter") {
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
 * Concatenate single quote ('')
 */
function list(table, key, value, domain='') {

    // General Declaration
    let sql = "";
    let rs = "";

    try {

        // Create query to fill dropdown        
        sql += ' select';
        sql += ' id as key,'; 
        sql += " field->>'label' as value"; 
        sql += ' from tb_field'; 
        sql += " where field->>'id_table' = '3'"
        rs = query(sql);

        return rs;
        

    } catch (ex) {

    }
}

/*
 * Empty form to input new record
 */
function FormNew() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "new";
    document.form1.submit();
}
function FormEdit() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "edit";
    document.form1.submit();
}
function FormDelete() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "delete";
    document.form1.submit();
}
function FormFilter() {
    document.getElementById("_FORMAT_").value = 2;
    document.getElementById("_EVENT_").value = "filter";
    document.form1.submit();
}
function ReportBack() {
    document.getElementById("_FORMAT_").value = 1;
    document.getElementById("_EVENT_").value = 'back';
    document.form1.submit();
}