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

            <!-- Model    
            <li class="nav-item dropdown">           
                <a class="nav-link dropdown-toggle" href="#" id="menu" data-toggle="dropdown">Administração</a>
                <div class="dropdown-menu" aria-labelledby="menu">
                    <a class="dropdown-item" href="#">Action</a>
                </div>            
            </li>
            -->
            <?php echo $menu; ?>
           
        </ul>
    </div>

    <!-- Topnav aligned right -->
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            <a href="" class="text-white">&nbsp;&nbsp;&nbsp;</a>
            </li>
        </ul>
    </div>
    
</nav>

<br>
<br>
<br>

<div class="container-fluid">
    <div class="row">

        <!-- Left side -->
        <div id="left1" class="col-sm-1">
        </div>

        <!-- Middle center -->        
        <div id="center1" class="col-sm-11">
            <?php echo $html;?>
        </div>    

    </div>
</div>