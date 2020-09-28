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

<!-- Add dependencies-->
<?php include "php/lib.php";?>

<br>
<body onKeyDown="__shortcut__(event)" onload="<?php echo $onLoadFunctions;?>">
<form id="form1" name="form1" action="index.php" method="post">

    <!-- Session info -->
    <?php include "php/layout.php";?>

    <!-- Session info -->
    <?php include "php/hidden.php";?>
 
</form>
</body>
</html>
        
        