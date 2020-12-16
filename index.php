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

<ul class="nav nav-tabs" id="myTab" role="tablist">

  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>   
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>   
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
  </li>
</ul>


<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">abcdefgh</div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">12345</div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
</div>


-->