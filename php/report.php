<?php
class Report extends Base {

    // Public members
    public $PageEvent = "";
    public $FormData = "";
    public $PageOffset = "";
    public $Event = "";   

    // Private members
    private $cn = 0;
    private $sqlBuilder = 0;
    private $tableDef = "";
    private $element = "";    

    // Constructor
    function __construct($cn, $sqlBuilder) {
        $this->cn = $cn;
        $this->sqlBuilder = $sqlBuilder;
        $this->element = new HTMLElement($this->cn, $this->sqlBuilder);        
    }

    /* 
    * Create a table
    */
    function createReport($tableId) {

        // General Declaration
        $html = "";
        $row = "";
        $rows = "";
        $col = "";
        $cols = "";        
        $fieldLabel = "";
        $fieldName = "";
        $data = "";
        $filter = "";
        $checked = "";
        $radio = "";
        $fk = 0;
        $recordCount = 0;       
        $PAGE_SIZE = 20;

        try {

            // Create object instances
            $this->element = new HTMLElement($this->cn, $this->sqlBuilder);

            // Get table structure
            $this->tableDef = $this->sqlBuilder->getTableDef($this->cn, "json");

            // Get data
            $filter = new Filter();
            if ($this->Event == "Filter") {
                $filter->setFilter($this->tableDef, $this->FormData);
            }

            // Paging
            $this->sqlBuilder->PageSize = $PAGE_SIZE;
            $this->sqlBuilder->PageOffset = $this->PageOffset;
            $data = $this->sqlBuilder->Query($this->cn, $tableId, $filter->create());
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
                    $tableFk = $col["table_fk"];
                    $fieldFk = $col["field_fk"];
                    $fieldName = $col["field_name"];
                    $fk = $col["id_fk"];

                    // Print right fields
                    if ($fk == 0) {
                        $cols .= $this->element->createTableCol($row[$fieldName]);
                    } else {
                        $cols .= $this->element->createTableCol($row[substr($fieldName, 3)]);
                    }
                }

                $rows .= $this->element->createTableRow($cols);
            }

            // Create page title
            $html .= $this->element->createPageTitle($this->getPageTitle($tableId));

            // Create final table
            $html .= $this->element->createTable($rows);

            // Get events (buttons)
            $html .= $this->element->createPaging($recordCount, 
                                                  $this->sqlBuilder->PageSize, 
                                                  $this->sqlBuilder->PageOffset);
        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        }

        // Return report        
        return $html;
    }

    /*
     * Get page title
     */
    private function getPageTitle($tableId) {
        // General declartion 
        $pageTitle = "";
        // Table has no definition yet
        if (!$this->tableDef) {
            $filter = new Filter();
            $filter->add("tb_table", "id", $tableId);
            $data = $this->sqlBuilder->Query($this->cn, 2, $filter->create());
            $pageTitle = $data[0]["title"];
        } else {
            $pageTitle = $this->tableDef[0]["title"];
        }

        return $pageTitle;
    }    
}
?>