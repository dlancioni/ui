
/*
 * Functions used in system events 
 */
async function confirm() {

    let actionDelete = 3;
    let actionFilter = 6;

    if (validateForm()) {
        if (getAction() == actionFilter) {
            setPaging(0);
            go(getModule(), 1, getAction());
        } else {
            await persist(getFormData()).then(alert);
            if (getAction() == actionDelete) {
                reportBack();
            }
        }
    }
}

/*
 * See base.php, must have same definition as here
 */
function formNew() {
    setFormat(2);
    setEvent(1);
    submit();
}

function formEdit() {
    setFormat(2);
    setEvent(2);
    submit();
}

function formDelete() {
    setFormat(2);
    setEvent(3);
    submit();
}

function formDetail(id) {
    setId(id);
    setFormat(3);
    setEvent(4);
    submit();
}

function formFilter() {
    setFormat(2);
    setEvent(6);
    submit();
}

function reportBack() {
    setFormat(1);
    setEvent(8);
    submit();
}

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