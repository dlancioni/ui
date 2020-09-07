/*
  * It manipulates hidden fields in index.htm
 */
function getTable() {
    return field("_TABLE_").value;
}
function setTable(value) {
    return field("_TABLE_").value = value;
}

function getFormat() {
    return field("_FORMAT_").value;
}
function setFormat(value) {
    return field("_FORMAT_").value = value;
}

function getEvent() {
    return field("_EVENT_").value;
}
function setEvent(value) {
    return field("_EVENT_").value = value;
}

function getPaging() {
    return field("_PAGING_").value;
}
function setPaging(value) {
    return field("_PAGING_").value = value;
}

/*
 * Functions used to navigate between pages
 */
function submit(param="form1") {
    form = document.getElementById(param);
    form.submit();
}

function go(table=0, format=1, event="") {
    setTable(table);
    setFormat(format);
    setEvent(event);
    setPaging(0);
    submit();
}

/*
 * Paging effect
 */
function paging(pageOffset) {
    setPaging(pageOffset);
    submit();
}