/*
 * Navigate to page in table or form format
 */
function go(table=0, style=1, event=0) {
    document.getElementById("_TABLE_").value = table;
    document.getElementById("_FORMAT_").value = style;
    document.getElementById("_EVENT_").value = event;
    document.form1.submit();
}

/*
 * Save current form
 */
function save() {
    let info = "";
    let data = "";
    let httpService = new HTTPService();
    info = httpService.persist(getFormData());
    alert(info);
}

/*
 * Read form and return array
 */
function getFormData() {
    let json = "";
    let form = document.getElementById('form1');
    let data = new FormData(form);
    return new URLSearchParams(data).toString();
}