
<!-- Add menus -->
<?php 
if (isset($_SESSION["_MENU_"])) {
    include "php/page/menuon.php";
} else {
    include "php/page/menuoff.php";
}
?>

<br>
<br>
<br>

<div class="container-fluid">
    <div class="row">

        <!-- Add logout button -->
        <?php include "php/page/login.php";?>

        <!-- Left side -->
        <div id="left1" class="col-sm-1">
        </div>

        <!-- Middle center -->        
        <div id="center1" class="col-sm-10">
            <?php echo $html;?>
        </div>    

        <!-- Left side -->
        <div id="right1" class="col-sm-1">
        </div>        

    </div>
</div>

<script>
$('[data-submenu]').submenupicker();
</script>