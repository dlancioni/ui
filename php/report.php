<?php
class Report extends Base {

    private $cn = 0;
    private $sqlBuilder = 0;

    // Constructor
    function __construct($cn, $sqlBuilder) {
        $this->cn = $cn;
        $this->sqlBuilder = $sqlBuilder;
    }

    /* 
    * Create a table
    */
    function createReport($tableId, $formData, $event) {

        // General Declaration
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
        $pageTitle = "";

        try {

            // DB interface
            $element = new HTMLElement($this->cn, $this->sqlBuilder);

            // Get table structure
            $tableDef = $this->sqlBuilder->getTableDef($this->cn, "json");

            // No table struct, just present title
            if (!$tableDef) {
                $filter = new Filter();
                $filter->add("tb_table", "id", $tableId);
                $data = $this->sqlBuilder->Query($this->cn, 2, $filter->create());
                $pageTitle = $data[0]["title"];
            } else {
                $pageTitle = $tableDef[0]["title"];
            }

            // Get data
            $filter = new Filter();
            if ($event == "Filter") {
                $filter->setFilter($tableDef, $formData);
            }
            $data = $this->sqlBuilder->Query($this->cn, $tableId, $filter->create());

            // Render html table
            $cols = $element->createTableHeader("");
            $cols .= $element->createTableHeader("Id");
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
                $cols .= $element->createTableCol($row["id"]);

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

            // Create page title
            $html .= $element->createPageTitle($pageTitle);

            // Create final table
            $html .= $element->createTable($rows);

            // Get events (buttons)
            $html .= $element->createEvent($tableId, 1);

        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        }

        // Return report        
        return $html;
    }
}
?>