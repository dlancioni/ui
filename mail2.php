<?php
include "php/include.php";
include "php/session.php";
include "php/core.php";
?>


<?php 
$mail = new Mail();
$mail->send2("dlancioni@gmail.com", "First test", "classe enviando email");
?>