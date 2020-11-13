<?php
include "page.include.php";
include "page.session.php";
include "page.core.php";
?>


<?php 
$mail = new Mail();
$mail->send("dlancioni@gmail.com", "First test", "classe enviando email");
?>