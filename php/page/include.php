<?php
    // Regular code
    include "exception.php";

    $path = __DIR__  . "/../class/";
    
    // Base class
    include  $path . "base.php";

    // Include classes
    include  $path . "auth.php";
    include  $path . "db.php";
    include  $path . "element.php";
    include  $path . "eventaction.php";    
    include  $path . "event.php";
    include  $path . "filter.php";    
    include  $path . "field.php";
    include  $path . "form.php";    
    include  $path . "model.php";
    include  $path . "mail.php";
    include  $path . "menu.php";
    include  $path . "persist.php";
    include  $path . "report.php";
    include  $path . "setup.php";
    include  $path . "setupcore.php";
    include  $path . "setupentity.php";
    include  $path . "sqlbuilder.php";
    include  $path . "table.php";
    include  $path . "tabbed.php";
    include  $path . "util.php";    
    include  $path . "upload.php";
    include  $path . "view.php";
    include  $path . "viewfield.php";

?>    