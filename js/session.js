/*
  * It manipulates hidden fields in index.htm
 */
function getModule() {
    return field("_MODULE_").value;
}
function setModule(value) {
    return field("_MODULE_").value = value;
}

function getFormat() {
    return field("_FORMAT_").value;
}
function setFormat(value) {
    return field("_FORMAT_").value = value;
}

function getAction() {
    return field("_ACTION_").value;
}
function setEvent(value) {
    return field("_ACTION_").value = value;
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

function go(module=0, format=1, event=0) {
    setModule(module);
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