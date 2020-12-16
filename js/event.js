
/*
 * Functions used in system events 
 */
async function confirm() {
    if (validateForm()) {
        if (getAction() == "Filter") {
            setPaging(0);
            go(getTable(), 1, getAction());
        } else {
            await persist(getFormData()).then(alert);
            if (getAction() == "Delete") {
                reportBack();
            }
        }
    }
}

/*
 * Basic operations
 */
function formNew() {
    setFormat(2);
    setEvent("New");
    submit();
}

function formEdit() {
    setFormat(2);
    setEvent("Edit");
    submit();
}

function formDelete() {
    setFormat(2);
    setEvent("Delete");
    submit();
}

function formDetail() {
    setFormat(3);
    setEvent("Detail");
    submit();
}

function formFilter() {
    setFormat(2);
    setEvent("Filter");
    submit();
}

function reportBack() {
    setFormat(1);
    setEvent("Back");
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