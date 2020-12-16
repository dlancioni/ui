<?php
include "php/page/include.php";
include "php/page/session.php";
include "php/page/core.php";
?>

<html>
<head>    
<title>UI</title>
</head>    
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Add dependencies-->
<?php include "php/page/lib.php";?>
<!-- Form load -->
<body onload="<?php echo $onLoadFunctions;?>">
    <!-- Base form -->
    <form id="form1" name="form1" action="index.php" method="post" enctype="multipart/form-data">
        <!-- Page body -->
        <?php include "php/page/body.php";?>
        <!-- Session Info -->
        <?php include "php/page/hidden.php";?>
    </form>
</body>
</html>



<!--
<div class='tab'>

    <ul class='nav nav-tabs'>   
        <li class='nav-item'>
            <a href='#home' class='nav-link active' data-toggle='tab'>Home</a>
        </li>
        <li class='nav-item'>
            <a href='#profile' class='nav-link' data-toggle='tab'>Profile</a>
        </li>
        <li class='nav-item'>
            <a href='#messages' class='nav-link' data-toggle='tab'>Messages</a>
        </li>
    </ul>

    <div class='tab-content'>
        <div class='tab-pane fade show active' id='home'>
            <p>1234</p>
        </div>
        <div class='tab-pane fade' id='profile'>
            <p>5678</p>
        </div>
        <div class='tab-pane fade' id='messages'>
            <p>90</p>
        </div>
    </div>
</div>
-->