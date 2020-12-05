<?php
include "include.php";
include "session.php";
include "core.php";
?>


<?php 
$mail = new Mail();
$mail->send("dlancioni@gmail.com", "First test", "classe enviando email");
?>