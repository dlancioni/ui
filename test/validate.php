<?php


function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}




if (validateEmail("david@lancioni.net")) {
    echo "true";
} else {
    echo "false";
}

?>