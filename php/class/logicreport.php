<?php
class LogicReport extends Base {

    // Public members
    public $PageEvent = "";
    public $Event = "";   

    // Private members
    private $cn = 0;
    private $sqlBuilder = 0;
    private $tableDef = "";
    private $element = "";    
    public $formData = "";

    // Constructor
    function __construct($cn, $sqlBuilder, $formData) {
        $this->cn = $cn;
        $this->sqlBuilder = $sqlBuilder;
        $this->formData = $formData;
        $this->element = new HTMLElement($this->cn, $this->sqlBuilder);
    }

    /* 
    * Create a table
    */
    function createReport($tableId, $pageOffset) {

        // General Declaration
        $html = "";
        $row = "";
        $rows = "";
        $col = "";
        $cols = "";        
        $fieldId = "";        
        $fieldLabel = "";
        $fieldName = "";
        $fieldType = 0;
        $dataType = "";
        $fieldValue = "";
        $data = array();
        $filter = "";
        $checked = "";
        $radio = "";
        $fk = 0;
        $recordCount = 0;       
        $numberUtil = "";
        $jsonUtil = "";
        $PAGE_SIZE = 15;
        $link = "";
        $columnSize = "";
        $fieldAttribute = "";

        try {

            // Create object instances
            $numberUtil = new NumberUtil();
            $jsonUtil = new jsonUtil();
            $pathUtil = new PathUtil();            
            $message = new Message($this->cn, $this->sqlBuilder);            
            $this->element = new HTMLElement($this->cn, $this->sqlBuilder);

            // Get table structure
            $this->tableDef = $this->sqlBuilder->getTableDef($this->cn, $tableId);
            if (count($this->tableDef) == 0) {

            }

            // Get data
            $filter = new Filter("like");
            if ($this->Event == "Filter") {
                $filter->setFilter($this->tableDef, $this->formData);
                $_SESSION["_FILTER_"][$tableId] = array($this->formData);
            } else {
                if (isset($_SESSION["_FILTER_"][$tableId])) {
                    $filter->setFilter($this->tableDef, $_SESSION["_FILTER_"][$tableId][0]);
                }
            }

            // Paging
            $this->sqlBuilder->PageSize = $PAGE_SIZE;
            $this->sqlBuilder->PageOffset = $pageOffset;
            $data = $this->sqlBuilder->executeQuery($this->cn, $tableId, $filter->create());
            if ($data) {
                $recordCount = $data[0]["record_count"];
            }

            // Render html table
            $cols = $this->element->createTableHeader("");
            $cols .= $this->element->createTableHeader("Id");
            foreach ($this->tableDef as $item) {
                $fieldLabel = $item["field_label"];
                $cols .= $this->element->createTableHeader($fieldLabel);
            }
            $rows .= $this->element->createTableRow($cols);

            // Prepare table contents
            $cols = "";
            foreach ($data as $row) {

                // Create radio for selection
                $cols == "" ? $checked = "checked" : $checked = "";
                $radio = $this->element->createRadio("selection", $row["id"], $checked);
                $cols = $this->element->createTableCol($radio);
                $cols .= $this->element->createTableCol($row["id"]);

                // Create data contents                
                foreach ($this->tableDef as $col) {

                    // Keep info
                    $fieldId = $col["id"];
                    $tableFk = $col["table_fk"];
                    $fieldFk = $col["field_fk"];
                    $fieldName = $col["field_name"];
                    $fieldType = $col["field_type"];
                    $dataType = $col["data_type"];
                    $fk = $col["id_fk"];
                    $fieldAttribute = $col["setup"];

                    // Field attribute
                    $columnSize = $jsonUtil->getValue($fieldAttribute, "size");

                    // Get field values
                    if ($fk == 0) {
                        $fieldValue = $row[$fieldName];
                    } else {
                        $fieldValue = $row[substr($fieldName, 3)];
                    }

                    // Format values
                    switch ($fieldType) {
                        case $this->TYPE_FLOAT: 
                            $fieldValue = number_format($fieldValue, 2, ',', '.');
                            break;
                        case $this->TYPE_PASSWORD:
                            $fieldValue = "******";
                            break;
                        case $this->TYPE_FILE:
                            if ($fieldValue != null) {
                                $link = $pathUtil->getVirtualPath() . $fieldValue;
                                $fieldValue = $this->element->createLink($this->element->createImage($link), $fieldValue, $link, true);
                            }
                            break;
                    }

                    // Print it
                    $cols .= $this->element->createTableCol($fieldValue, $columnSize);
                }

                $rows .= $this->element->createTableRow($cols);
            }

            // Create page title
            $html .= $this->element->createPageTitle($tableId);

            // Create final table
            $html .= $this->element->createTable($rows);

            // Get events (buttons)
            $html .= $this->element->createPaging($recordCount, 
                                                  $this->sqlBuilder->PageSize, 
                                                  $this->sqlBuilder->PageOffset);

            // Space between form and buttons
            $html .= "<br><br>";

        } catch (Exception $ex) {
            throw $ex;
        }

        // Return report        
        return $html;
    }
}
?>