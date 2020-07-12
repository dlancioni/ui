<?php
include "src/session.php";
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

<div class="w3-container">
    <div id="div1">
        <?php
        include "src/page.php";
        ?>
    </div>    
</div>

<script src="js/src/util.js"></script>
<script src="js/src/httpservice.js"></script>
<script src="js/src/element.js"></script>
<script src="js/src/script.js"></script>
<script src="js/src/menu.js"></script>
<script src="js/src/table.js"></script>
<script src="js/src/form.js"></script>
</body>
</html>
        
        