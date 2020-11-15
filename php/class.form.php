<?php
class LogicForm extends Base {

    // Public members
    public $action = "";
    public $PageEvent = "";
    public $tableDef = "";    

    // Private members
    private $cn = 0;
    private $sqlBuilder = 0;
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
        $defaultValue = "";

        $label = "";
        $control = "";
        $controls = "";
        $cascade = array();
        $pageTitle = "";

        $control = "";
        $jsonUtil = "";
        $jsonUtil = new jsonUtil();
        $numberUtil = new NumberUtil();

        try {

            // Handle events
            if ($this->action == "Delete") {
                $disabled = "disabled";
            }

            if ($this->action == "Filter") {
                $id = 0;
            }

            // Get table structure
            if (count($this->tableDef) > 0) {

                // Keep page title
                $pageTitle = $this->tableDef[0]["title"];
                
                // Do not query database
                if ($this->action == "Filter") {
                    if (isset($_SESSION["_FILTER_"][$tableId])) {
                        $data = $_SESSION["_FILTER_"][$tableId];
                    }                    
                } else {
                    // Get data
                    $filter = new Filter();
                    $filter->add($this->tableDef[0]["table_name"], "id", $id);
                    $data = $this->sqlBuilder->executeQuery($this->cn, $tableId, $filter->create());
                }

                // Create field Id (rules according to action)
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
                    $defaultValue = "";
                    $fieldMask = "";
                    $placeHolder = "";

                    $fk = $item["id_fk"];
                    $fieldId = $item["id"];
                    $fieldLabel = $item["field_label"];
                    $fieldName = $item["field_name"];
                    $fieldType = $item["field_type"];
                    $fieldMask = $item["field_mask"];
                    $fieldMandatory = $item["field_mandatory"];
                    $fieldDomain = $item["field_domain"];
                    $defaultValue = $item["default_value"];                    
                    $fieldValue = "";
                    $control = $item["id_control"];

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

                    // Apply default value
                    if (trim($fieldValue) == "" ) {
                        $fieldValue = trim($defaultValue);
                    }

                    // Format values
                    if ($fieldType == $this->TYPE_FLOAT) {
                        if ($fieldValue != "") {
                            $fieldValue = $numberUtil->valueOf($fieldValue);
                            $fieldValue = number_format($fieldValue, 2, ',', '.');
                        }
                    }

                    // Accumulate JS for validation
                    $js .= $this->element->createJs($fieldLabel, 
                                                    $fieldName,
                                                    $fieldType, 
                                                    $fieldValue, 
                                                    $fieldMask, 
                                                    $fieldMandatory, 
                                                    $fk, 
                                                    $this->action);
                    
                    // Add label                
                    $label = $this->element->createLabel($fieldLabel, $fieldName);

                    // No label for hidden field
                    if ($control == $this->INPUT_HIDDEN) {
                        $label = "";
                    }


                    // Add field (textbox or dropdown)
                    if ($fk == 0) {
                        
                        // Format values
                        switch ($control) {
                            case $this->INPUT_TEXTAREA:
                                $control = $this->element->createTextarea($fieldId, $fieldName, $fieldValue, $disabled, $this->PageEvent);
                                break;
                            case $this->INPUT_FILE:
                                $control = $this->element->createUpload($fieldId, $fieldName, $fieldValue);
                                break;
                            case $this->INPUT_PASSWORD:
                                $control = $this->element->createTextbox($fieldId, "password", $fieldName, $fieldValue, $placeHolder, $disabled, $this->PageEvent);
                                break;
                            case $this->INPUT_HIDDEN:
                                $control = $this->element->createTextbox($fieldId, "hidden", $fieldName, $fieldValue, $placeHolder, $disabled, $this->PageEvent);
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

                    // Cannot filter on binary fields
                    if ($this->action == "Filter") {
                        if ($fieldType != $this->TYPE_BINARY) {
                            $controls .= $this->element->createFieldGroup($label, $control);
                        }
                    } else {
                        $controls .= $this->element->createFieldGroup($label, $control);                        
                    }
                }
            }

            // Create page title
            $html .= $this->element->createPageTitle($pageTitle);

            // Finalize form
            $html .= $this->element->createForm("form1", $controls);

            // Add validateForm function
            $html .= $this->element->createScript($js);


        } catch (Exception $ex) {
            $this->setError("LogicForm.createForm()", $ex->getMessage());
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
        switch ($this->action) {
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