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

//alert(list('tb_field', 'id', 'label', domain=''));