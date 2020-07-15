<?php

include "php/session.php";
?>

<html>
<head>    
<title>UI</title>
</head>    
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/menu.css">
<body>
<form name="form1" action="index.php" method="post">
<div class="w3-container">
    <div id="div1">
        <?php
        include "php/page.php";
        ?>
    </div>    
</div>

<input type="hidden" id="page" name="page" value="">

<script src="js/httpservice.js"></script>
<script src="js/function.js"></script>
</form>
</body>
</html>
        
        