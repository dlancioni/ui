<?php

/*
echo uniqid();
echo "<br>";
echo strlen(uniqid());
*/

//$previous_name = session_name("WebsiteID");

echo "O nome da sessão: " . session_name();
session_name(uniqid());
echo "O nome da sessão: " . session_name();

?>
