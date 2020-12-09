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

    // Session related variables
    if (isset($_REQUEST["_FORMAT_"])) {
        $format = intval($_REQUEST["_FORMAT_"]);
        $_SESSION['_FORMAT_'] = intval($format);
    }

    if (isset($_REQUEST["_ACTION_"])) {
        $action = $_REQUEST["_ACTION_"];
        $_SESSION['_ACTION_'] = $action;
    }

    if (isset($_REQUEST["_VIEW_"])) {
        $viewId = intval($_REQUEST["_VIEW_"]);
        $_SESSION['_VIEW_'] = intval($viewId);
    }

    if (isset($_REQUEST["_TABLE_"])) {
        $tableId = intval($_REQUEST["_TABLE_"]);
        if ($_SESSION['_TABLE_'] != $tableId) {
            $viewId = 0;
            $_SESSION["_VIEW_"] = $viewId;
        }
        $_SESSION['_TABLE_'] = intval($tableId);
    }

    if (isset($_REQUEST["selection"])) {
        $id = intval($_REQUEST['selection']);
        if ($action == "filter") {
            $id = 0;
        }
        $_SESSION['_ID_'] = intval($id);
    }

    if (isset($_REQUEST["_PAGING_"])) {
        $pageOffset = intval($_REQUEST["_PAGING_"]);
    }

?>
