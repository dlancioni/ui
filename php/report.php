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
        $TB_EVENT = 5;

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
                $cols == "" ? $checked = "checked" : $checked = "";
                $radio = $element->createRadio("selection", 
                                               $row["id"], 
                                               $checked);

                $cols = $element->createTableCol($radio);
                foreach ($tableDef as $col) {
                    $fieldName = $col["field_name"];
                    $cols .= $element->createTableCol($row[$fieldName]);
                }
                $rows .= $element->createTableRow($cols);
            }

            // Create final table
            $html .= $element->createTable($rows);

            // Get events (buttons)
            $html .= "<br>";
            $filter = new Filter();
            $filter->add("tb_event", "id_target", 1);
            $filter->add("tb_event", "id_table", $tableId);
            $sql = $sqlBuilder->getQuery($cn, $TB_EVENT, $filter->create());
            $data = $db->queryJson($cn, $sql); 
            
            foreach ($data as $item) {
                $html .= $element->createButton($item["label"], 
                                                $item["label"], 
                                                $item["id_event"],
                                                $item["code"]);
            }

        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        } finally {
                
        }

        return $html;
    }
}
?>