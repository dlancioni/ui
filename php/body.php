
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
        <?php include "php/login.php";?>

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


<!-- Temp 
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand">Forms</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" tabindex="0" data-toggle="dropdown" data-submenu>Cadastros</a>
                <div class="dropdown-menu">
                    <button class="dropdown-item" type="button">Clientes</button>


            <div class="dropdown dropright dropdown-submenu">                   
            <button class="dropdown-item dropdown-toggle" type="button">Entidades</button>
            <div class="dropdown-menu">
                <button class="dropdown-item" type="button">Clientes</button>
                <button class="dropdown-item" type="button">Fornecedores</button>
                
            <div class="dropdown dropright dropdown-submenu">
            <button class="dropdown-item dropdown-toggle" type="button">Funcionarios</button>
            <div class="dropdown-menu">
                <button class="dropdown-item" type="button">PF</button>
                <button class="dropdown-item" type="button">PJ</button>
    </div>
</nav>
 -->






<script>
$('[data-submenu]').submenupicker();
</script>