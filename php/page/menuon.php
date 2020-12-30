<!-- Main container -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

    <!-- Title/Logo -->
    <a class="navbar-brand" href="#"><b>Forms</b></a>
    
    <!-- Hamburger -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu items (modules)-->
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">       
            <?php 
            echo $_SESSION["_MENU_"]; 
            ?>
        </ul>
    </div>
</nav>