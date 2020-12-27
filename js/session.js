 /*
  * It manipulates hidden fields in index.htm
  */

// Current module
function getModule() {
    return field("_MODULE_").value;
}
function setModule(value) {
    return field("_MODULE_").value = value;
}

// Current format (table or form)
function getFormat() {
    return field("_FORMAT_").value;
}
function setFormat(value) {
    return field("_FORMAT_").value = value;
}

// Current event (New, Edit, Delete)
function getEvent() {
    return field("_EVENT_").value;
}
function setEvent(value) {
    return field("_EVENT_").value = value;
}

// Current page
function getPaging() {
    return field("_PAGING_").value;
}
function setPaging(value) {
    return field("_PAGING_").value = value;
}

// Current or selected record
function getId() {
    return field("_PARENT_").value;
}
function setId(value) {
    field("_PARENT_").value = value;
}

/*
 * Functions used to navigate between pages
 */
function submit(param="form1") {
    form = document.getElementById(param);
    form.submit();
}

function go(module=0, format=1, event=0, id=0) {
    setModule(module);
    setFormat(format);
    setEvent(event);
    setId(id);
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