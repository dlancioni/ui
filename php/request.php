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

    // Current module
    if (isset($_REQUEST["_TABLE_"])) {
        $tableId = $_REQUEST["_TABLE_"];
        $_SESSION['_TABLE_'] = $tableId;
    }

    // Current format (table or form)
    if (isset($_REQUEST["_FORMAT_"])) {
        $format = $_REQUEST["_FORMAT_"];
        $_SESSION['_FORMAT_'] = $format;
    }

    // Current event (new, save, delete)
    if (isset($_REQUEST["_EVENT_"])) {
        $event = $_REQUEST["_EVENT_"];
        $_SESSION['_EVENT_'] = $event;
    }

    // Current record
    if (isset($_REQUEST["selection"])) {
        $id = intval($_REQUEST['selection']);
        if ($event == "filter") {
            $id = 0;
        }
        $_SESSION['_ID_'] = $id;
    }

?>
