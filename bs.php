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

    <!-- Main container -->
    <div class="w3-container">

        <!-- Topnav -->
        <div class="w3-row">
            <div class="w3-container w3-black">
                <img src="" width="50" heigth="50">
            </div>
        </div>

        <!-- Main area -->
        <div class="w3-row">       

            <!-- Main menu -->
            <div class="w3-quarter">
                <div class="w3-panel">
                    <?php echo $mainMenu; ?>
                </div>
            </div>

            <!-- Contents -->
            <div class="w3-threequarter">
                <div class="w3-panel">
                <?php echo $html;?>
                </div>            
            </div>

        </div>
    </div>

    <!-- Session info -->
    <?php include "php/page.php";?>
 
</form>
</body>
</html>
        
        