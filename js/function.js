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
    info = httpService.persist(data);
    alert(info);
}