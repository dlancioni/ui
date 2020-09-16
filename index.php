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

<body onKeyDown="__shortcut__(event)" onload="<?php echo $onLoadFunctions; ?>">
<form id="form1" name="form1" action="index.php" method="post">

    <br>
    <div class="w3-container" >
        <div class="w3-row">
            <div class="w3-container w3-quarter w3-black">
                <p>Home</p>
            </div>
            <div class="w3-container w3-quarter w3-black">
                <p>&nbsp;</p>
            </div>
            <div class="w3-container w3-quarter w3-black">
                <p>&nbsp;</p>
            </div>
            <div class="w3-container w3-quarter w3-black">
                <p>&nbsp;</p>
            </div>
        </div>
    </div>     

    <div class="w3-row">
        <div class="w3-quarter w3-container" >
            <?php echo $mainMenu; ?>
        </div>
        <div class="w3-threequarter w3-container">
            <?php echo $html;?>
        </div>
    </div>

    <input type="hidden" id="_TABLE_" name="_TABLE_" value="<?php echo $tableId; ?>">
    <input type="hidden" id="_FORMAT_" name="_FORMAT_" value="<?php echo $format; ?>">
    <input type="hidden" id="_EVENT_" name="_EVENT_" value="<?php echo $event; ?>">
    <input type="hidden" id="_PAGING_" name="_PAGING_" value="<?php echo $pageOffset; ?>">

    <script src="js/filesaver.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/httpservice.js"></script>
    <script src="js/session.js"></script>
    <script src="js/db.js"></script>
    <script src="js/event.js"></script>
    <script src="js/validation.js"></script>
    <script src="js/format.js"></script>
    <script src="js/field.js"></script>
   
</form>
</body>
</html>
        
        