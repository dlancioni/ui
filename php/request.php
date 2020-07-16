<?php

    /*
    * Keep IDs (table, style and record) and navigate to page
    * Important, changes here must reflect:
    * index.php -> Create hidden fields
    * page.php -> Declare variables do receive values
    * request.php -> Request values on above variables
    * Recommended to clear history after changes
    * Finally, $-REQUEST[] uses field NAME, not ID
    */

    if (isset($_REQUEST["_TABLE_"])) {
        $tableId = $_REQUEST["_TABLE_"];
    }

    if (isset($_REQUEST["_STYLE_"])) {
        $style = $_REQUEST["_STYLE_"];
    }

    if (isset($_REQUEST["selection"])) {
        $id = intval($_REQUEST['selection']);
    }        

?>
