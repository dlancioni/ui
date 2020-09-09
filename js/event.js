
/*
 * Functions used in system events 
 */
function confirm() {
    if (getEvent() == "Filter") {
        setPaging(0);
        go(getTable(), 1, getEvent());
    } else {
        if (validateForm()) {
            alert(persist(getFormData()));
            if (getEvent() == "Delete") {
                reportBack();
            }
        }
    }
}

function formNew($tableId) {
    setFormat(2);
    setEvent("New");
    submit();
}
function formEdit($tableId) {
    setFormat(2);
    setEvent("Edit");
    submit();
}
function formDelete($tableId) {
    setFormat(2);
    setEvent("Delete");
    submit();
}
function formFilter($tableId) {
    setFormat(2);
    setEvent("Filter");
    submit();
}
function reportBack($tableId) {
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

/*
 * Shortcut to manipulate native functionalities
 */
function __shortcut__(e) {

    // Navigate on menu
    if (e.which == 49) {
        if (e.altKey) {go(1, 1);}
    }    
    if (e.which == 50) {
        if (e.altKey) {go(2, 1);}
    }
    if (e.which == 51) {
        if (e.altKey) {go(3, 1);}
    }
    if (e.which == 52) {
        if (e.altKey) {go(4, 1);}
    }
    if (e.which == 53) {
        if (e.altKey) {go(5, 1);}
    }
    if (e.which == 54) {
        if (e.altKey) {go(6, 1);}
    }
    if (e.which == 55) {
        if (e.altKey) {go(7, 1);}
    }
    if (e.which == 56) {
        if (e.altKey) {go(8, 1);}
    }

    // Buttons
    if (e.which == 49) {
        if (e.ctrlKey) {formNew(getTable());}
    }
    if (e.which == 50) {
        if (e.ctrlKey) {formEdit(getTable());}
    }
    if (e.which == 51) {
        if (e.ctrlKey) {formEdit(getTable());}
    }
    if (e.which == 52) {
        if (e.ctrlKey) {formFilter(getTable());}
    }

    // Confirm, Clear, Back
    if (e.which == 53) {
        confirm();
    }
    if (e.which == 54) {
        if (e.ctrlKey) {formClear();}
    }
    if (e.which == 55) {
        if (e.ctrlKey) {reportBack();}
    }
    if (e.which == 56) {
        if (e.ctrlKey) {
            setPaging(0);
            go(getTable(), 1, getEvent());    
        }
    }

}
