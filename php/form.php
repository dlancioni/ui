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
        
        $fieldLabel = "";
        $fieldId = "";
        $fieldName = "";
        $fieldType = "";
        $fieldValue = "";
        $fieldMask = "";
        $fieldMandatory = "";
        
        $html = "";
        $data = "";
        $dataFk = "";
        $filter = "";
        $tableName = "";
        $pageTitle = "";
        $disabled = "";
        $placeHolder = "";

        try {

            // Handle events
            if ($this->Event == "Delete") {
                $disabled = "disabled";
            }

            if ($this->Event == "Filter") {
                $id=0;
            }

            // Get table structure
            $this->tableDef = $this->sqlBuilder->getTableDef($this->cn, "json");

            // Get page title
            $pageTitle = $this->getPageTitle();

            // Get data
            $filter = new Filter();
            $filter->add($this->tableDef[0]["table_name"], "id", $id);
            $data = $this->sqlBuilder->Query($this->cn, $tableId, $filter->create());

            // Create field Id (rules according to event)
            $rows .= $this->createId($data, $placeHolder, $disabled);

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

                foreach($data as $col) {
                    $fieldValue = $col[$fieldName];
                    break;
                }

                // Accumulate JS for validation
                $js .= $this->createJs($fieldLabel, 
                                       $fieldName,
                                       $fieldType, 
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
                    if ($fieldType == 6) {
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
            $html .= $this->element->createPageTitle($pageTitle);

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
    private function getPageTitle() {
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

    /*
     * Create field ID
     */
    private function createId($data, $placeHolder, $disabled) {
        // General declaration
        $cols = "";
        $rows = "";

        if ($data) {
            if ($this->Event != "New") {
                $cols .= $this->element->createTableCol($this->element->createLabel("id", "id"));
                $cols .= $this->element->createTableCol($this->element->createTextbox(0, "id", $data[0]["id"], $placeHolder, $disabled));
                $rows .= $this->element->createTableRow($cols);
            }
        } else {
            $cols .= $this->element->createTableCol($this->element->createLabel("id", "id"));
            $cols .= $this->element->createTableCol($this->element->createTextbox(0, "id", "", $placeHolder, $disabled));
            $rows .= $this->element->createTableRow($cols);
        }

        return $rows;
    }

    /*
     * Javascript generation
     */
    private function createJs($fieldLabel, $fieldName, $fieldType, $fieldValue, $fieldMask, $fieldMandatory, $fk) {

        // General declaration
        $js = "";
        $stringUtil = new StringUtil();        

        // Temporary message
        $message = $stringUtil->dqt("Campo obrigatorio $fieldLabel");                

        // Prepare values        
        $fieldLabel = $stringUtil->dqt($fieldLabel);
        $fieldName = $stringUtil->dqt($fieldName);

        if ($fieldMandatory) {

            $js .= "if (!isMandatory($fieldName, $message)) {";
            $js .= "return false;";
            $js .= "} ";
        }

        // Just return
        return $js;
    }    
}
?>