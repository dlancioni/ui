<?php

    // Start session
    session_start();

//$sSomeVar = 'something';
//echo eval( 'return $sSomeVar = 3;' );

$command = '$_SESSION["status"] = 0;';
echo eval($command);


echo $_SESSION['status'];


?>