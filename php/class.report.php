<?php
class LogicReport extends Base {

    // Public members
    public $PageEvent = "";
    public $action = "";   
    public $tableDef = "";

    // Private members
    private $cn = 0;
    private $sqlBuilder = 0;
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
        $control = "";
        $pageTitle = "";
        $tableDef = "";

        try {

            // Create object instances
            $numberUtil = new NumberUtil();
            $jsonUtil = new jsonUtil();
            $pathUtil = new PathUtil();            
            $message = new Message($this->cn, $this->sqlBuilder);            
            $this->element = new HTMLElement($this->cn, $this->sqlBuilder);
            $tableDef = $this->tableDef;
            $formData = $this->formData;

            // Get table structure
            if (count($tableDef) > 0) {
                $pageTitle = $tableDef[0]["title"];
            }

            // Get data
            $filter = new Filter("like");
            if ($this->action == "Filter") {
                $filter->setFilter($tableDef, $formData);
                $_SESSION["_FILTER_"][$tableId] = array($formData);
            } else {
                if (isset($_SESSION["_FILTER_"][$tableId])) {
                    $filter->setFilter($tableDef, $_SESSION["_FILTER_"][$tableId][0]);
                }
            }

            // Paging
            $this->sqlBuilder->PageSize = $PAGE_SIZE;
            $this->sqlBuilder->PageOffset = $pageOffset;
            $data = $this->sqlBuilder->executeQuery($this->cn, $tableId, $filter->create(), 1, $tableDef);

            if ($this->sqlBuilder->getError() != "") {
                $this->setError("LogicReport.createReport()", $this->sqlBuilder->getError());
                return;
            }

            if ($data) {
                $recordCount = $data[0]["record_count"];
            }

            // Render html table
            $cols = $this->element->createTableHeader("");
            $cols .= $this->element->createTableHeader("Id");
            foreach ($tableDef as $item) {
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
                foreach ($tableDef as $col) {

                    // Keep info
                    $fieldId = $col["id"];
                    $tableFk = $col["table_fk"];
                    $fieldFk = $col["field_fk"];
                    $fieldName = $col["field_name"];
                    $fieldType = $col["field_type"];
                    $fk = $col["id_fk"];
                    $control = $col["id_control"];

                    // Field attribute
                    $columnSize = 0;


                    // Get field values
                    if ($fk == 0) {
                        $fieldValue = $row[$fieldName];
                    } else {
                        $fieldValue = $row[substr($fieldName, 3)];
                    }

                    // Handle field type (datatype)
                    switch ($fieldType) {
                        case $this->TYPE_FLOAT: 
                            $fieldValue = number_format($fieldValue, 2, ',', '.');
                            break;
                        case $this->TYPE_BINARY: 
                            break;                            
                        default:    
                    }

                    // Handle field element (html control)
                    switch ($control) {

                        case $this->INPUT_PASSWORD:
                            $fieldValue = "******";
                            break;

                        case $this->INPUT_FILE:
                            if ($fieldValue != null) {
                                $link = $pathUtil->getVirtualPath() . $fieldValue;
                                $fieldValue = $this->element->createLink($this->element->createImage($link), $fieldValue, $link, true);
                            }
                            break;

                        default:
                    }

                    // Print it
                    $cols .= $this->element->createTableCol($fieldValue, $columnSize);
                }

                $rows .= $this->element->createTableRow($cols);
            }

            // Create page title
            $html .= $this->element->createPageTitle($pageTitle);

            // Create final table
            $html .= $this->element->createTable($rows);

            // Get events (buttons)
            $html .= $this->element->createPaging($recordCount, 
                                                  $this->sqlBuilder->PageSize, 
                                                  $this->sqlBuilder->PageOffset);

            // Space between form and buttons
            $html .= "<br><br>";

        } catch (Exception $ex) {
            $this->setError("LogicReport.createReport()", $ex->getMessage());
        }

        // Return report        
        return $html;
    }
}
?>