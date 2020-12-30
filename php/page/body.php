
<!-- Main container -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

    <!-- Title/Logo -->
    <a class="navbar-brand" href="#"><b>Forms</b></a>
    
    <!-- Hamburger -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <?php 
    if (!isset($_SESSION["_MENU_"])) {
    ?>    
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#modalRegister">Cadastre-se</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#modalRetrieveCredential">Esqueci a senha</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#modalLogin">Login</a>
                </li>            
            </ul>
        </div>
    <?php    
    }
    ?>

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