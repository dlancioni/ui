<?php
class LogicForm extends Base {

    // Public members
    public $Event = "";
    public $PageEvent = "";

    // Private members
    private $cn = 0;
    private $sqlBuilder = 0;
    private $tableDef = array();
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
        $k = "";
        $v = "";
        $kid = 0;                        
        $function = "";

        $js = "";
        $key = "";
        $value = "";
        $cols = "";
        $rows = "";
        
        $html = "";
        $data = "";
        $dataFk = "";
        $filter = "";
        $tableName = "";
        $disabled = "";
        $placeHolder = "";

        $fieldId = "";
        $fieldLabel = "";
        $fieldName = "";
        $fieldType = 0;
        $fieldMask = "";
        $fieldMandatory = "";
        $fieldDomain = "";
        $fieldValue = "";
        $datatype = "";

        $label = "";
        $control = "";
        $controls = "";
        $cascade = array();

        // Constants
        $TEXT_AREA = 6;
        $FILE = 7;
        $PASSWORD = 8;

        try {

            // Handle events
            if ($this->Event == "Delete") {
                $disabled = "disabled";
            }

            if ($this->Event == "Filter") {
                $id = 0;
            }

            // Get table structure
            $this->tableDef = $this->sqlBuilder->getTableDef($this->cn, $tableId);
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
                    $data = $this->sqlBuilder->executeQuery($this->cn, $tableId, $filter->create());
                }

                // Create field Id (rules according to event)
                $controls .= $this->createId($data, $placeHolder, $disabled);
            }

            // Keep cascade info for current transaction
            $filter = new Filter();
            $filter->add("tb_domain", "domain", "tb_cascade");
            $cascade = $this->sqlBuilder->executeQuery($this->cn, $this->TB_DOMAIN, $filter->create());            

            // Create base form
            if (is_array($this->tableDef)) {
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

                    if (is_array($data)) {
                        foreach($data as $col) {
                            if (isset($col[$fieldName])) {
                                $fieldValue = $col[$fieldName];
                                break;                        
                            }
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
                    $label = $this->element->createLabel($fieldLabel, $fieldName);

                    // Add field (textbox or dropdown)
                    if ($fk == 0) {

                        if ($fieldName == "password") {
                            echo 1;
                        }                    
                        
                        // Format values
                        switch ($fieldType) {
                            case $this->TYPE_TEXTAREA:
                                $control = $this->element->createTextarea($fieldId, $fieldName, $fieldValue, $disabled, $this->PageEvent);
                                break;
                            case $this->TYPE_FILE:
                                $control = $this->element->createUpload($fieldId, $fieldName, $fieldValue);
                                break;
                            case $this->TYPE_PASSWORD:
                                $control = $this->element->createTextbox($fieldId, "password", $fieldName, $fieldValue, $placeHolder, $disabled, $this->PageEvent);
                                break;
                            default:
                                $control = $this->element->createTextbox($fieldId, "text", $fieldName, $fieldValue, $placeHolder, $disabled, $this->PageEvent);
                        }

                    } else {

                        // Append dropdown
                        if ($fk == $this->TB_DOMAIN) {
                            $key = "key";
                            $value = "value";
                            $filter = new Filter();
                            $filter->add("tb_domain", "domain", $fieldDomain);
                        } else {                        
                            $key = "id";
                            $value = $item["field_fk"];
                            $filter = new Filter();                        
                        }

                        // Cascade logic
                        $function = "";

                        if (is_array($cascade)) {
                            foreach ($cascade as $field) {

                                // Keep cascade configuration
                                $kid = -1;
                                $k = explode(".", $field["key"]);
                                $v = explode(";", $field["value"]);

                                // Control dropdown on load
                                if (trim($item["field_name"]) == trim($v[0])) {
                                    if (isset($data[0][$k[1]])) {
                                        $kid = $data[0][$k[1]];
                                        $filter->add($v[1], str_replace("_fk", "", $k[1]), $kid);
                                    }
                                }

                                // Call cascade function
                                if (trim($item["table_name"]) == trim($k[0])) {
                                    if (trim($item["field_name"]) == trim($k[1])) {
                                        $function = $this->element->createCascade($k, $v);
                                    }
                                }
                            }
                        }

                        // Get FK related data
                        $dataFk = $this->sqlBuilder->executeQuery($this->cn, $fk, $filter->create());                        

                        // Create control
                        $control = $this->element->createDropdown($fieldId,
                                                                $fieldName, 
                                                                $fieldValue, 
                                                                $dataFk, 
                                                                $key, 
                                                                $value, 
                                                                $function,
                                                                $this->PageEvent,
                                                                $disabled);
                    }

                    // Add current col to rows
                    $controls .= $this->element->createFieldGroup($label, $control);
                }
            }

            // Create page title
            $html .= $this->element->createPageTitle($tableId, $this->Event);

            // Finalize form
            $html .= $this->element->createForm("form1", $controls);

            // Add validateForm function
            $html .= $this->element->createScript($js);


        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        }

        // Return form
        return $html;
    }

    /*
     * Create field ID
     */
    private function createId($data, $placeHolder, $disabled) {
        // General declaration
        $id = "";
        $fieldId = "_id_";
        $controls = "";
        $show = 1;

        // Keep value
        if (isset($data[0]["id"])) {
            $id = $data[0]["id"];
        }

        // Control access
        switch ($this->Event) {
            case "New":
                $id = "";
                $disabled = "disabled";
                $show = 0;
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

        // Create field group
        if ($show == 1) {
            $controls .= $this->element->createFieldGroup(
                $this->element->createLabel("id", "id"), 
                    $this->element->createTextbox(0, "text", $fieldId, $id, $placeHolder, $disabled));
        }

        // Just return it
        return $controls;
    }
}
?>