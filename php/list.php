<?php
class Table extends Base {

    /* 
    * Create a table
    */
    function createTable($id) {

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
            $tableDef = json_decode($sqlBuilder->getTableDef("json"), true);

            // Get data
            $filter = new Filter();
            $sql = $sqlBuilder->getQuery($filter->create());
            $data = json_decode($db->queryJson($sql), true);

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

            // Finalize table    
            $html .= $element->createTable($rows);

        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        } finally {
                
        }

        return $html;
    }
}
?>