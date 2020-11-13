<?php


function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}




if (validateEmail("")) {
    echo "true";
} else {
    echo "false";
}

?>