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

    if (isset($_REQUEST["_EVENT_"])) {
        $event = $_REQUEST["_EVENT_"];
        $_SESSION['_EVENT_'] = $event;
    }

    if (isset($_REQUEST["_VIEW_"])) {
        $viewId = intval($_REQUEST["_VIEW_"]);
        $_SESSION['_VIEW_'] = intval($viewId);
    }

    if (isset($_REQUEST["_MODULE_"])) {
        $moduleId = intval($_REQUEST["_MODULE_"]);
        if (isset($_SESSION['_MODULE_'])) {
            if ($_SESSION['_MODULE_'] != $moduleId) {
                $viewId = 0;
                $_SESSION["_VIEW_"] = $viewId;
            }
        }
        $_SESSION['_MODULE_'] = intval($moduleId);
    }

    if (isset($_REQUEST["_PAGING_"])) {
        $pageOffset = intval($_REQUEST["_PAGING_"]);
    }

    if (isset($_REQUEST["_ID_"])) {
        $id = intval($_REQUEST['_ID_']);
        if ($event == "filter") {
            $id = 0;
        }
        $_SESSION['_ID_'] = intval($id);
    }

    if (isset($_REQUEST["_PARENT_"])) {
        if (intval($_REQUEST['_PARENT_']) != 0) {
            $id = intval($_REQUEST['_PARENT_']);
        }
    }

?>
