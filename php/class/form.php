<?php
class Form extends Base {

    // Public members
    public $Event = "";
    public $PageEvent = "";

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
    * Create new form
    */
    function createForm($tableId, $id=0) {

        // General Declaration
        $js = "";
        $key = "";
        $value = "";
        $cols = "";
        $rows = "";
        
        $html = "";
        $data = [];
        $dataFk = "";
        $filter = "";
        $tableName = "";
        $disabled = "";
        $placeHolder = "";

        $fieldId = "";
        $fieldLabel = "";
        $fieldName = "";
        $fieldType = "";
        $fieldMask = "";
        $fieldMandatory = "";
        $fieldDomain = "";
        $fieldValue = "";
        $datatype = "";

        // Constants
        $TEXT_AREA = 6;
        $TB_DOMAIN = 4;

        try {

            // Handle events
            if ($this->Event == "Delete") {
                $disabled = "disabled";
            }

            if ($this->Event == "Filter") {
                $id = 0;
            }

            // Get table structure
            $this->tableDef = $this->sqlBuilder->getTableDef($this->cn);
            if (count($this->tableDef) > 0) {
                
                // Do not query database
                if ($this->Event == "Filter") {
                    if (isset($_SESSION["_FILTER_"][$tableId])) {
                        $data = $_SESSION["_FILTER_"][$tableId];
                    }                    
                } else {
                    // Get data
                    $filter = new Filter();
                    $filter->add($this->tableDef[0]["table_name"], "id", $id);
                    $data = $this->sqlBuilder->Query($this->cn, $tableId, $filter->create());
                }

                // Create field Id (rules according to event)
                $rows .= $this->createId($data, $placeHolder, $disabled);
            }            

            // Create base form
            foreach($this->tableDef as $item) {

                // Get structure
                $cols = "";                
                $fk = $item["id_fk"];
                $fieldId = $item["id"];
                $fieldLabel = $item["field_label"];
                $fieldName = $item["field_name"];
                $fieldType = $item["field_type"];
                $fieldMask = $item["field_mask"];
                $fieldMandatory = $item["field_mandatory"];
                $fieldDomain = $item["field_domain"];
                $datatype = $item["data_type"];
                $fieldValue = "";

                // Placeholder provide information about data type
                if ($fieldMask != "") {
                    $placeHolder = $fieldMask;
                }

                foreach($data as $col) {
                    if (isset($col[$fieldName])) {
                        $fieldValue = $col[$fieldName];
                        break;                        
                    }
                }

                // Format values
                if ($datatype == "float") {
                    if ($fieldValue != "") {
                        $fieldValue = number_format($fieldValue, 2, ',', '.');
                    }
                }                

                // Accumulate JS for validation
                $js .= $this->element->createJs($fieldLabel, 
                                                $fieldName,
                                                $datatype, 
                                                $fieldValue, 
                                                $fieldMask, 
                                                $fieldMandatory, 
                                                $fk);
                
                // Add label                
                $cols .= $this->element->
                    createTableCol($this->element->
                        createLabel($fieldLabel, $fieldName));

                // Add field (textbox or dropdown)
                if ($fk == 0) {

                    // Append textbox or text area
                    if ($fieldType == $TEXT_AREA) {
                        $cols .= $this->element->
                            createTableCol($this->element->
                            createTextarea($fieldId, 
                                           $fieldName, 
                                           $fieldValue, 
                                           $disabled, 
                                           $this->PageEvent));
                    } else {

                        $cols .= $this->element->
                            createTableCol($this->element->
                                createTextbox($fieldId, 
                                            $fieldName, 
                                            $fieldValue, 
                                            $placeHolder, 
                                            $disabled, 
                                            $this->PageEvent));
                    }

                } else {

                    // Append dropdown
                    if ($fk == $TB_DOMAIN) {
                        $key = "key";
                        $value = "value";
                        $filter = new Filter();
                        $filter->add("tb_domain", "domain", $fieldDomain);
                    } else {                        
                        $key = "id";
                        $value = $item["field_fk"];
                        $filter = new Filter();                        
                    }

                    // Get related data and create element
                    $dataFk = $this->sqlBuilder->Query($this->cn, $fk, $filter->create());
                    $cols .= $this->element->
                        createTableCol($this->element->
                            createDropdown($fieldId,
                                           $fieldName, 
                                           $fieldValue, 
                                           $dataFk, 
                                           $key, 
                                           $value, 
                                           $this->PageEvent, 
                                           $disabled));
                }

                // Add current col to rows
                $rows .= $this->element->createTableRow($cols);
            }

            // Create page title
            $html .= $this->element->createPageTitle($this->getPageTitle($tableId));

            // Finalize form
            $html .= $this->element->createForm("form1", $this->element->createTable($rows));

            // Add validateForm function
            $html .= $this->element->createScript($js);            


        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        }

        // Return form
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
            $pageTitle = $data[0]["name"];
        } else {
            $pageTitle = $this->tableDef[0]["name"];
        }

        return $pageTitle;
    }

    /*
     * Create field ID
     */
    private function createId($data, $placeHolder, $disabled) {
        // General declaration
        $id = "";
        $cols = "";
        $rows = "";
        $fieldId = "_id_";        

        // Keep value
        if (isset($data[0]["id"])) {
            $id = $data[0]["id"];
        }

        // Control access
        switch ($this->Event) {
            case "New":
                $id = "";
                $disabled = "disabled";
                break;                
            case "Edit":
                $disabled = "disabled";
                break;                
            case "Delete":
                $disabled = "disabled";
                break;
            default:
                $disabled = "";
        }

        // Create field
        $cols .= $this->element->createTableCol($this->element->createLabel("id", "id"));
        $cols .= $this->element->createTableCol($this->element->createTextbox(0, $fieldId, $id, $placeHolder, $disabled));
        $rows .= $this->element->createTableRow($cols);

        return $rows;
    }

}
?>