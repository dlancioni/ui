<?php
include "php/include.php";
include "php/session.php";
include "php/page.php";
?>

<html>
<head>    
<title>UI</title>
</head>    
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">

<body onload="<?php echo $onLoadFunctions; ?>">
<form id="form1" name="form1" action="index.php" method="post">

    <div class="w3-row">
      <div class="w3-col w3-container" style="width:20%"><?php echo $mainMenu; ?></div>  
      <div class="w3-col w3-container" style="width:80%"><?php echo $html;?></div>
    </div>

    <input type="hidden" id="_TABLE_" name="_TABLE_" value="<?php echo $tableId; ?>">
    <input type="hidden" id="_FORMAT_" name="_FORMAT_" value="<?php echo $format; ?>">
    <input type="hidden" id="_EVENT_" name="_EVENT_" value="<?php echo $event; ?>">
    <input type="hidden" id="_PAGING_" name="_PAGING_" value="<?php echo $pageOffset; ?>">

    <script src="js/filesaver.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/httpservice.js"></script>
    <script src="js/function.js"></script>
   
</form>
</body>
</html>
        
        