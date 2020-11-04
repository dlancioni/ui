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
        $format = $_REQUEST["_FORMAT_"];
        $_SESSION['_FORMAT_'] = $format;
    }
    if (isset($_REQUEST["_EVENT_"])) {
        $event = $_REQUEST["_EVENT_"];
        $_SESSION['_EVENT_'] = $event;
    }
    if (isset($_REQUEST["selection"])) {
        $id = intval($_REQUEST['selection']);
        if ($event == "filter") {
            $id = 0;
        }
        $_SESSION['_ID_'] = $id;
    }
    if (isset($_REQUEST["_PAGING_"])) {
        $pageOffset = $_REQUEST["_PAGING_"];
    }

    if (isset($_REQUEST["_TABLE_"])) {
        if ($_REQUEST["_TABLE_"] != "0") {
            if ($_SESSION['_TABLE_'] != $_REQUEST["_TABLE_"]) {
                $tableId = $_REQUEST["_TABLE_"];
                $_SESSION['_TABLE_'] = $tableId;

                // Get events
                $filter = new Filter();
                $filter->add("tb_event", "id_table", $tableId);
                $_SESSION["_PAGE_EVENT_"] = $sqlBuilder->executeQuery($cn, $sqlBuilder->TB_EVENT, $filter->create(), $sqlBuilder->QUERY_NO_PAGING);

                // Get table def
                $_SESSION['_TABLEDEF_'] = $sqlBuilder->getTableDef($cn, $tableId);     
            }
        }
    }

    if (isset($_SESSION["_PAGE_EVENT_"])) {
        $pageEvent = $_SESSION["_PAGE_EVENT_"];
    }

    if (isset($_SESSION["_TABLE_"])) {
        $tableId = $_SESSION['_TABLE_'];
    }

    if (isset($_SESSION["_TABLEDEF_"])) {
        $tableDef = $_SESSION['_TABLEDEF_'];
    }   

?>
