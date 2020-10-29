<!-- Main container -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

    <!-- Title/Logo -->
    <a class="navbar-brand" href="#"><b>Forms</b></a>
    
    <!-- Hamburger -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">       
            <?php 
            if (isset($_SESSION["_MENU_"])) {
                echo $_SESSION["_MENU_"]; 
            }
            ?>
        </ul>
    </div>

</nav>

<br>
<br>
<br>

<div class="container-fluid">
    <div class="row">

        <!-- Add logout button -->
        <?php include "php/formlogin.php";?>

        <!-- Left side -->
        <div id="left1" class="col-sm-1">
        </div>

        <!-- Middle center -->        
        <div id="center1" class="col-sm-11">
            <?php echo $html;?>
        </div>    

    </div>
</div>