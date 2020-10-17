<?php

    // Start session
    session_start();

//$sSomeVar = 'something';
//echo eval( 'return $sSomeVar = 3;' );

$command = 'return $_SESSION["status"] = "Fechamento";';
echo eval($command);


echo $_SESSION['status'];


?>