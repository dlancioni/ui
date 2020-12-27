
/*
 * Functions used in system events 
 */
async function confirm() {

    let eventDelete = 3;
    let eventFilter = 5;

    if (validateForm()) {
        if (getEvent() == eventFilter) {
            setPaging(0);
            go(getModule(), 1, getEvent());
        } else {
            await persist(getFormData()).then(alert);
            if (getEvent() == eventDelete) {
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

function formFilter() {
    setFormat(2);
    setEvent(5);
    submit();
}

function reportBack() {
    setFormat(1);
    setEvent(7);
    submit();
}

function formDetail(id) {
    setId(id);
    setFormat(3);
    setEvent(9);
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