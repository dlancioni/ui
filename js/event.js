
/*
 * Functions used in system events 
 */
function confirm() {
    if (getEvent() == "Filter") {
        setPaging(0);
        go(getTable(), 1, getEvent());
    } else {
        if (validateForm()) {
            //alert(persist(getFormData()));
            async_confirm();
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







async function async_confirm() {

    try {

        const data = new URLSearchParams();
        let form = document.getElementById('form1');
        let formData = new FormData(form);
        for (const pair of formData) {
            data.append(pair[0], pair[1]);
        }

        var input = document.querySelector('input[type="file"]')         
        if (input != null) {
            for (let file of input.files) {
                data.append('file', file, file.name)
            }
        }

        let response = await fetch('./php/persist.php', {
            method: 'POST',
            body: data
        });

        let result = await response.text();

        alert(result);

    } catch (ex) {
      alert("Erro: " + ex);
    }

    
  }
