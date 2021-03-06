/*
 * Validate mandatory fields
 */
function validateMandatory(fieldName, fk, message) {
    if (fk == 0) {
        if(field(fieldName).value == '') {
            alert(message);
            field(fieldName).focus();
            return false;
        }
    } else {
        if(field(fieldName).value == 0) {
            alert(message);
            field(fieldName).focus();
            return false;
        }
    }
    return true;
}

/*
 * Validate dates
 */
function validateDate(fieldName, mask, message="") {

    if (field(fieldName).value == "") {
        return true;
    }

    let dt = moment(field(fieldName).value, mask.toUpperCase(), true);

    if (dt.isValid()) {
        return true;
    } else {
        if (message != "") {
            alert(message);
            field(fieldName).focus();
        }
        return false;
    }
}

/*
 * Validate numerics
 */
function validateNumeric(fieldName, message="") {

    if (isNumeric(field(fieldName).value)) {    
        return true;
    } else {
        if (message != "") {
            alert(message);
            field(fieldName).focus();
            return false;    
        }
    }   
}

/*
 * Check if native value is numeric
 */
function isNumeric(value) {

    value = value.replace(".", "");
    value = value.replace(",", "");

    if (isNaN(value)) {
        return false;
    } else  {
        return true;
    }
}