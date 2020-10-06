
/*
 * Functions used in system events 
 */
async function confirm() {
    if (getEvent() == "Filter") {
        setPaging(0);
        go(getTable(), 1, getEvent());
    } else {
        if (validateForm()) {
            let formData = getFormData();
            async_confirm(formData).then(alert);
            if (getEvent() == "Delete") {
                reportBack();
            }
        }
    }
}

/*
 * Basic operations
 */
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
    if (e.altKey) {
        go(parseInt(e.key), 1);
    }
}







async function async_confirm(formData) {

    try {

        // Submit it        
        let response = await fetch('./php/persist.php', {
            method: 'POST',
            body: formData
        });

        // Return processing results
        return await response.text();

    } catch (ex) {

        // Error handling
        return ex;
    }

    
  }
