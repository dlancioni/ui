<?php
class Table extends Base {

    /* 
    * Create a table
    */
    function createTable($cn, $tableId) {

        // General Declaration        
        $db = "";
        $html = "";
        $sqlBuilder = "";
        $fieldLabel = "";
        $fieldName = "";
        $tableDef = "";
        $data = "";
        $filter = "";
        $row = "";
        $col = "";
        $cols = "";
        $rows = "";
        $checked = "";
        $radio = "";
        $fk = 0;

        try {

            // DB interface
            $db = new Db();
            $element = new HTMLElement();

            // Keep instance of SqlBuilder for current session
            $sqlBuilder = new SqlBuilder($this->getSystem(), 
                                         $this->getTable(), 
                                        $this->getUser(), 
                                        $this->getLanguage());
            // Get table structure
            $tableDef = $sqlBuilder->getTableDef($cn, "json");

            // Get data
            $filter = new Filter();
            $sql = $sqlBuilder->getQuery($cn, $tableId, $filter->create());
            $data = $db->queryJson($cn, $sql);
            error_log($sql);

            // Render html table
            $cols = $element->createTableHeader("");
            foreach ($tableDef as $item) {
                $fieldLabel = $item["field_label"];
                $cols .= $element->createTableHeader($fieldLabel);
            }
            $rows .= $element->createTableRow($cols);

            // Prepare table contents
            $cols = "";
            foreach ($data as $row) {

                // Create radio for selection
                $cols == "" ? $checked = "checked" : $checked = "";
                $radio = $element->createRadio("selection", $row["id"], $checked);
                $cols = $element->createTableCol($radio);

                // Create data contents                
                foreach ($tableDef as $col) {

                    // Keep info
                    $tableFk = $col["table_fk"];
                    $fieldFk = $col["field_fk"];
                    $fieldName = $col["field_name"];
                    $fk = $col["id_fk"];

                    // Print right fields
                    if ($fk == 0) {
                        $cols .= $element->createTableCol($row[$fieldName]);
                    } else {
                        $cols .= $element->createTableCol($row[substr($fieldName, 3)]);
                    }
                }

                $rows .= $element->createTableRow($cols);
            }

            // Create final table
            $html .= $element->createTable($rows);

            // Get events (buttons)
            $html .= $element->createEvent($cn, $sqlBuilder, $tableId, 1);

        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        }

        // Return report        
        return $html;
    }
}
?>