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
<form id="form1" name="form1" action="index.php" method="post">

<div class="w3-container">
    <div id="div1">
        <?php
        include "php/page.php";
        ?>
    </div>    
</div>

<input type="hidden" id="_TABLE_" name="_TABLE_" value="<?php echo $tableId; ?>">
<input type="hidden" id="_FORMAT_" name="_FORMAT_" value="<?php echo $format; ?>">
<input type="hidden" id="_EVENT_" name="_EVENT_" value="<?php echo $event; ?>">

<script src="js/httpservice.js"></script>
<script src="js/function.js"></script>
</form>
</body>
</html>
        
        