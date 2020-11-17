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
        $viewId = 0;

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

            // Handle view
            if (trim($tableDef[0]["id_view"]) != "") {
                $viewId = trim($tableDef[0]["id_view"]);
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

            if ($viewId > 0) {
                $data = $this->sqlBuilder->executeView($this->cn, $viewId, $filter->create());
            } else {
                $data = $this->sqlBuilder->executeQuery($this->cn, $tableId, $filter->create(), 1, $tableDef);
            }

            // Error handling    
            if ($this->sqlBuilder->getError() != "") {
                $this->setError("LogicReport.createReport()", $this->sqlBuilder->getError());
                return;
            }

            // Handle count
            if ($data) {
                if (isset($data[0]["record_count"])) {
                    $recordCount = $data[0]["record_count"];
                }
            }

            // Create header
            $rows .= $this->createTableHeader($viewId, $data);

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
                    $columnSize = 0;                    
                    $fieldId = $col["id"];
                    $tableFk = $col["table_fk"];
                    $fieldFk = $col["field_fk"];
                    $fieldName = $col["field_name"];
                    $fieldType = $col["field_type"];
                    $fk = $col["id_fk"];
                    $control = $col["id_control"];

                    if ($fk != 0) {
                        $fieldName = substr($fieldName, 3);
                    }

                    // Prepare grid
                    if (isset($row[$fieldName])) {

                        // Get field value
                        $fieldValue = $row[$fieldName];

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


    /*
     * Create table header
     */
    private function createTableHeader($viewId, $data) {

        // General Declaration
        $cols = "";
        $fieldName = "";
        $fieldLabel = "";
        $tableDef = $this->tableDef;

        // Create checkbox columns
        $cols = $this->element->createTableHeader("");
        $cols .= $this->element->createTableHeader("Id");

        // Create header
        foreach ($tableDef as $item) {

            $fieldName = $item["field_name"];
            $fieldLabel = $item["field_label"];

            // For view, fields may does not exists in data            
            if ($viewId > 0) {
                foreach ($data as $row) {
                    if (!isset($row[$fieldName])) {
                        $fieldLabel = "";
                        break;
                    }
                }
            }

            // Add columns where both def and data exists
            if ($fieldLabel != "") {
                $cols .= $this->element->createTableHeader($fieldLabel);
            }
        }

        return $this->element->createTableRow($cols);
    }



}
?>