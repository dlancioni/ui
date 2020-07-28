<?php
class Form extends Base {

    // Private members
    private $cn = 0;
    private $sqlBuilder = 0;

    // Constructor
    function __construct($cn, $sqlBuilder) {
        $this->cn = $cn;
        $this->sqlBuilder = $sqlBuilder;
    }

    /* 
    * Create new form
    */
    function createForm($tableId, $id=0, $event) {

        // General Declaration
        $html = "";
        $sqlBuilder = "";
        $fieldLabel = "";
        $fieldName = "";
        $fieldType = "";
        $fieldValue = "";
        $tableDef = "";
        $data = "";
        $dataFk = "";
        $events = "";
        $filter = "";
        $tableName = "";
        $key = "";
        $value = "";
        $cols = "";
        $rows = "";
        $pageTitle = "";
        $disabled = "";

        try {

            // Handle events
            if ($event == "Delete") {
                $disabled = "disabled";
            }
            if ($event == "Filter") {
                $id=0;
            }            

            // DB interface
            $db = new Db();
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
            $filter->add($tableDef[0]["table_name"], "id", $id);
            $data = $this->sqlBuilder->Query($this->cn, $tableId, $filter->create());

            if ($data) {
                if ($event != "New") {
                    $cols .= $element->createTableCol($element->createLabel("id", "id"));
                    $cols .= $element->createTableCol($element->createTextbox("id", $data[0]["id"], "", $disabled));
                    $rows .= $element->createTableRow($cols);
                }
            } else {
                $cols .= $element->createTableCol($element->createLabel("id", "id"));
                $cols .= $element->createTableCol($element->createTextbox("id", "", "", $disabled));
                $rows .= $element->createTableRow($cols);
            }

            // Create base form
            foreach($tableDef as $item) {

                // Keep data
                $cols = "";                
                $fk = $item["id_fk"];
                $fieldLabel = $item["field_label"];
                $fieldName = $item["field_name"];
                $fieldType = $item["field_type"];
                foreach($data as $col) {
                    $fieldValue = $col[$fieldName];
                    break;
                }
                
                // Add label                
                $cols .= $element->createTableCol($element->createLabel($fieldLabel, $fieldName));

                // Add field (textbox or dropdown)
                if ($fk == 0) {

                    if ($fieldType == 6) {
                        $cols .= $element->createTableCol($element->createTextarea($fieldName, $fieldValue));
                    } else {
                        $cols .= $element->createTableCol($element->createTextbox($fieldName, $fieldValue, "", $disabled));
                    }
                } else {

                    if ($fk == 4) {
                        $key = "key";
                        $value = "value";
                        $filter = new Filter();
                        $filter->add("tb_domain", "domain", $item["field_domain"]);
                    } else {                        
                        $key = "id";
                        $value = $item["field_fk"];
                        $filter = new Filter();                        
                    }

                    $dataFk = $this->sqlBuilder->Query($this->cn, $fk, $filter->create());
                    $cols .= $element->createTableCol($element->createDropdown(
                        $fieldName, $fieldValue, $dataFk, $key, $value, "", $disabled));
                }

                // Add current col to rows
                $rows .= $element->createTableRow($cols);
            }

            // Create page title
            $html .= $element->createPageTitle($pageTitle);

            // Finalize form
            $html .= $element->createForm("form1", $element->createTable($rows));

        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        }

        // Return form
        return $html;
    }
}
?>