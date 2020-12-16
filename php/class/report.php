<?php
class LogicReport extends Base {

    // Public members
    public $queryType = 1; // See SqlBuilder, Paging declaration

    // Private members
    private $cn = 0;
    private $sqlBuilder = "";
    private $element = "";
    public $formData = array();    

    // Constructor
    function __construct($cn, $sqlBuilder, $formData) {
        $this->cn = $cn;
        $this->sqlBuilder = $sqlBuilder;
        $this->formData = $formData;
        $this->element = new HTMLElement($this->cn);
    }

    /* 
    * Create a table
    */
    function createReport($tableId, $viewId=0, $action="", $pageOffset=0) {

        // General Declaration
        $PAGE_SIZE = 15;

        $userId = 0;
        $viewType = 0;
        $recordCount = 0;

        $msg = "";
        $html = "";
        $tableRow = "";
        $filter = "";
        $control = "";
        $logUtil = "";
        $jsonUtil = "";
        $tableDef = "";
        $pageTitle = "";
        $fieldValue = "";

        $data = array();
        $viewList = array();
        $eventList = array();

        try {

            // Create object instances
            $logUtil = new LogUtil();
            $jsonUtil = new jsonUtil();
            $pathUtil = new PathUtil();
            $eventAction = new EventAction($this->cn);
            $message = new Message($this->cn);
            $this->element = new HTMLElement($this->cn);
            $formData = $this->formData;

            // Current user
            $userId = $this->sqlBuilder->getUser();

            // Handle structures
            if ($viewId != 0) {
                $tableDef = $this->sqlBuilder->getTableDef($this->cn, 0, $viewId);
            } else {
                $tableDef = $this->sqlBuilder->getTableDef($this->cn, $tableId, 0);
            }
            $logUtil->log("query_def.pgsql", $this->sqlBuilder->lastQuery);

            // Get table structure
            if ($viewId == 0) {
                if (count($tableDef) > 0) {
                    $pageTitle = $tableDef[0]["title"];
                } else {
                    $msg = $message->getValue("M19");
                    throw new Exception($msg);
                }
            } else {
                $pageTitle = $tableDef[0]["view_name"];
                $viewType = $tableDef[0]["view_type"];
            }

            // Create page title
            $this->pageTitle = $pageTitle;
            if ($this->showTitle) {
                $html .= $this->element->createPageTitle($pageTitle);
            }

            // Get data
            $filter = new Filter("like");
            if ($action == "Filter") {
                $filter->setFilter($tableDef, $formData);
                $_SESSION["_FILTER_"][$tableId] = array($formData);
            } else {
                if (isset($_SESSION["_FILTER_"][$tableId])) {
                    $filter->setFilter($tableDef, $_SESSION["_FILTER_"][$tableId][0]);
                }
            }

            // Main query
            $this->sqlBuilder->PageSize = $PAGE_SIZE;
            $this->sqlBuilder->PageOffset = $pageOffset;
            $data = $this->sqlBuilder->executeQuery($this->cn, $tableId, $viewId, $filter->create(), $this->queryType, $tableDef);
            $logUtil->log("query_data.pgsql", $this->sqlBuilder->lastQuery);

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

            // Present data according to the type
            switch ($viewType) {

                // Standard report view
                case $this->REPORT:
                    $tableRow .= $this->createTableHeader($viewId, $data, $tableDef, $this->sqlBuilder->CONDITION);
                    $tableRow .= $this->createTableData($tableDef, $data);
                    $html .= $this->element->createTable($tableRow);
                    break;

                // Line chart
                case $this->CHART_LINE:
                    $html .= $this->createChart("line", $tableDef, $data);
                    break;

                // Line chart    
                case $this->CHART_COLUMN:
                    $html .= $this->createChart("column", $tableDef, $data);
                    break;

                // Area chart    
                case $this->CHART_AREA:
                    $html .= $this->createChart("area", $tableDef, $data);
                    break;

                // Pizza chart    
                case $this->CHART_PIZZA:
                    $html .= $this->createChart("pie", $tableDef, $data);
                    break;

                // Standard report view                    
                default:
                    $tableRow .= $this->createTableHeader($viewId, $data, $tableDef, $this->sqlBuilder->CONDITION);
                    $tableRow .= $this->createTableData($tableDef, $data);
                    $html .= $this->element->createTable($tableRow);
            }

            // Get views
            $filter = new Filter();
            $filter->add("tb_view", "id_table", $tableId);
            $viewList = $this->sqlBuilder->executeQuery($this->cn, 
                                                        $this->TB_VIEW, 0, 
                                                        $filter->create(), 
                                                        $this->sqlBuilder->QUERY_NO_PAGING);


            // Create paging
            if ($this->showPaging) {
                $html .= $this->element->createPaging($recordCount, $this->sqlBuilder->PageSize, $this->sqlBuilder->PageOffset);
            }

            // Create buttons
            if ($this->showAction) {

                $filter = new Filter();
                $filter->add("tb_event", "id_table", $tableId);
                $eventList = $this->sqlBuilder->executeQuery($this->cn, 
                                                            $this->TB_EVENT, 0, 
                                                            $filter->create(), 
                                                            $this->sqlBuilder->QUERY_NO_PAGING);                
                $html .= $eventAction->createButton($tableId, $userId, $eventList, 1);
            }


            // Prepare view list
            $html .= $this->element->createPanel($this->createViewList($viewList, $viewId));            

        } catch (Exception $ex) {
            $this->setError("LogicReport.createReport()", $ex->getMessage());
        }

        // Return report        
        return $html;
    }

    /*
     * Create table header
     */
    private function createTableHeader($viewId, $data, $tableDef, $condition) {

        // General Declaration
        $cols = "";
        $fieldName = "";
        $fieldLabel = "";
        $command = 0;

        // Create checkbox columns
        if (isset($data[0]["id"]) || count($data) == 0) {
            $cols = $this->element->createTableHeader("");
            $cols .= $this->element->createTableHeader("Id");
        }

        // Create header
        foreach ($tableDef as $item) {

            $fieldName = $item["field_name"];
            $fieldLabel = $item["field_label"];
            if (isset($item["id_command"])) {
                $command = $item["id_command"];
            }

            // For view, fields may does not exists in data            
            if ($viewId > 0) {
                if (trim($item["field_label_view"]) != "") {
                    $fieldName = $item["field_label_view"];
                    $fieldLabel = $fieldName;
                }
            }

            if ($command > $condition) {
                $fieldLabel = "";
            }

            // Add columns where both def and data exists
            if ($fieldLabel != "") {
                $cols .= $this->element->createTableHeader($fieldLabel);
            }
        }

        return $this->element->createTableRow($cols);
    }

    /*
     * Define the column size according to the number of columns
     */
    private function getSize($columnCount, $column) {

        $size = 0;
        switch ($columnCount) {
            case 4:
                if ($column == 4) {
                    $size = 50;
                }
                break;

            case 3:
                if ($column == 3) {
                    $size = 65;
                }
                break;

            case 2:
                if ($column == 2) {
                    $size = 80;
                }
                break;

            case 1:
                if ($column == 1) {
                    $size = 95;
                }
                break;                
        }

        return $size;
    }

    /*
     * Prepare view list
     */
    private function createViewList($data, $viewId) {
        $html = "";
        $html .= "Visão" . "<br>";
        $event = "onChange='submit()'";
        if (count($data) > 0) {
            $html .= $this->element->createSimpleDropdown("_VIEW_", $data, "id", "name", $viewId, $event);
        }
        return $html;
    }

    /*
     * Get field name
     */
    private function prepareFieldName($col, $fieldName, $fk) {

        // Handle field name on views
        if (isset($col["field_label_view"])) {
            if (trim($col["field_label_view"]) != "") {
                $fieldName = trim($col["field_label_view"]);
            }
        } else {
            // Handle field name on joins
            if ($fk != 0) {
                $fieldName = substr($fieldName, 3);
            }
        }
        return $fieldName;
    }

    /*
     * Get field value
     */
    private function prepareFieldValue($fieldType, $fieldValue, $control) {

        $link = "";
        
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

        return $fieldValue;
    }

    private function prepareRadio($row) {

        $radio = "";
        $cols = "";
        $checked = "";

        if (isset($row["id"])) {
            $cols == "" ? $checked = "checked" : $checked = "";
            $radio = $this->element->createRadio("selection", $row["id"], $checked);

            if ($this->showAction) {
                $cols = $this->element->createTableCol($radio);
            } else {
                $cols = $this->element->createTableCol("");                
            }
            
            $cols .= $this->element->createTableCol($row["id"]);
        }

        return $cols;
    }

    private function createTableData($tableDef, $data) {

        // General declaration
        $fk = 0;
        $count = 0;
        $tableFk = 0;
        $fieldFk = 0;        
        $control = 0;
        $command = 0;        
        $columnSize = 0;
        $columnSize = 0;

        $tableRow = "";
        $fieldId = "";
        $fieldName = "";
        $fieldType = "";


        try {

            // Prepare table contents
            foreach ($data as $row) {

                // Start new column
                $cols = "";

                // Create radio for selection
                $cols = $this->prepareRadio($row);

                // Create data contents
                foreach ($tableDef as $col) {

                    // Keep info
                    $count ++;
                    $columnSize = 0;
                    $fieldId = $col["id"];
                    $tableFk = $col["table_fk"];
                    $fieldFk = $col["field_fk"];
                    $fieldName = $col["field_name"];
                    $fieldType = $col["field_type"];
                    $fk = $col["id_fk"];
                    $control = $col["id_control"];
                    $columnSize = $this->getSize(count($tableDef), $count);
                    $fieldName = $this->prepareFieldName($col, $fieldName, $fk);
                    if (isset($col["id_command"])) {
                        $command = $col["id_command"];
                    }

                    // Prepare grid
                    if (isset($row[$fieldName])) {

                        // Format field value
                        $fieldValue = $this->prepareFieldValue($fieldType, $row[$fieldName], $control);

                        // Print it
                        if ($command < $this->sqlBuilder->CONDITION) {
                            $cols .= $this->element->createTableCol($fieldValue, $columnSize);
                        }

                    } else {
                        
                        // Discard unselected columns on views
                        if ($command < $this->sqlBuilder->CONDITION) {
                            $cols .= $this->element->createTableCol("", $columnSize);
                        }
                    }
                }

                $tableRow .= $this->element->createTableRow($cols);
            }

        } catch (Exception $ex) {
            throw $ex;
        }

        // Return table contents
        return $tableRow;
    }    


    private function createChart($chartType, $tableDef, $data) {

        // General declaration
        $i = 0;
        $html = "";
        $label = "";
        $value = "";
        $datapoints = "";
        $fieldLabel = "";
        $fieldValue = "";

        try {

            // Get field names
            $fieldLabel = $tableDef[0]["field_label_view"];
            $fieldValue = $tableDef[1]["field_label_view"];

            // Prepare datapoints
            foreach ($data as $row) {
                if (isset($row[$fieldLabel])) {
                    if (isset($row[$fieldValue])) {

                        if ($i > 0) {
                            $datapoints .= ",";
                        }

                        $label = $row[$fieldLabel];
                        $value = $row[$fieldValue];
                        $datapoints .= "{y:$value, label:'$label'}"; 
                        $i ++;
                    }
                }
            }          

            // Print the chart
            $html .= $this->element->createChart($chartType, $datapoints);

        } catch (Exception $ex) {
            throw $ex;
        }

        // Return final chart
        return $html;
    }

} // end of class
?>