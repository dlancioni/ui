<?php
include "php/include.php";
include "php/session.php";
include "php/core.php";
?>

<html>
<head>    
<title>UI</title>
</head>    
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Add dependencies-->
<?php include "php/lib.php";?>
<!-- Form load -->
<body onload="<?php echo $onLoadFunctions;?>">
    <!-- Base form -->
    <form id="form1" name="form1" action="index.php" method="post" enctype="multipart/form-data">
        <!-- Page body -->
        <?php include "php/body.php";?>
        <!-- Session Info -->
        <?php include "php/hidden.php";?>
    </form>
</body>
</html>
        
        