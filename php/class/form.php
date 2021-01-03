<?php
class LogicForm extends Base {

    // Public members
    public $PageEvent = "";
    public $tableName = "";    

    // Private members
    private $cn = 0;
    private $sqlBuilder = 0;
    private $element = "";

    // Constructor
    function __construct($cn, $sqlBuilder) {
        $this->cn = $cn;
        $this->sqlBuilder = $sqlBuilder;
        $this->element = new HTMLElement($this->cn);
    }

    /* 
    * Create new form
    */
    function createForm($moduleId, $id=0, $event) {

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

        $viewId = 0;
        $fieldId = "";
        $fieldLabel = "";
        $fieldName = "";
        $fieldType = 0;
        $fieldMask = "";
        $fieldMandatory = "";
        $fieldDomain = "";
        $fieldValue = "";
        $defaultValue = "";
        $userId = 0;

        $label = "";
        $control = "";
        $controls = "";
        $pageTitle = "";
        $cascade = array();
        $tableDef = array();        

        $control = "";
        $jsonUtil = "";
        $jsonUtil = new jsonUtil();
        $numberUtil = new NumberUtil();
        $message = new Message($this->cn);
        $eventAction = new EventAction($this->cn);

        try {

            // Handle events
            if ($event == $this->ACTION_DELETE || $event == $this->ACTION_DETAIL) {
                $disabled = "disabled";
            }

            if ($event == $this->ACTION_FILTER) {
                $id = 0;
            }

            // Current user
            $userId = $this->sqlBuilder->getUser();

            // Get module structure
            $tableDef = $this->sqlBuilder->getTableDef($this->cn, $moduleId, 0);

            // Prepare the form
            if (count($tableDef) > 0) {

                // Keep page title
                $pageTitle = $tableDef[0]["title"];
                
                // Do not query database
                if ($event == $this->ACTION_FILTER) {
                    if (isset($_SESSION["_FILTER_"][$moduleId])) {
                        $data = $_SESSION["_FILTER_"][$moduleId];
                    }                    
                } else {

                    // No table name for style form, so no data
                    if ($tableDef[0]["id_style"] != $this->STYLE_FORM) {                    
                        $filter = new Filter();
                        $filter->add($tableDef[0]["table_name"], "id", $id);
                        $data = $this->sqlBuilder->executeQuery($this->cn, $moduleId, $viewId, $filter->create());
                    }
                }

                // Create field Id (rules according to event)
                if ($tableDef[0]["id_style"] != $this->STYLE_FORM) {
                    $controls .= $this->createId($data, $placeHolder, $disabled, $event);
                }

            } else {

                // Forms can be created by javascript, definition is not mandatory.
                return "";
            }

            // Keep cascade info for current transaction
            $filter = new Filter();
            $filter->add("tb_domain", "domain", "tb_cascade");
            $cascade = $this->sqlBuilder->executeQuery($this->cn, $this->TB_DOMAIN, $viewId, $filter->create());

            // Create base form
            if (is_array($tableDef)) {
                foreach($tableDef as $item) {

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
                                                    $event);
                    
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
                        $dataFk = $this->sqlBuilder->executeQuery($this->cn, $fk, $viewId, $filter->create());

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
                    if ($event == $this->ACTION_FILTER) {
                        if ($fieldType != $this->TYPE_BINARY) {
                            $controls .= $this->element->createFieldGroup($label, $control);
                        }
                    } else {
                        $controls .= $this->element->createFieldGroup($label, $control);                        
                    }
                }
            }

            // Create page title
            $this->pageTitle = $this->element->createPageTitle($pageTitle);
            if ($this->showTitle) {
                $html .= $this->element->createPageTitle($pageTitle);
            }    

            // Keep table name public
            $this->tableName = $tableDef[0]["table_name"];

            // Finalize form
            $html .= $this->element->createForm("form1", $controls);

            // Create buttons
            $html .= $eventAction->createButton($moduleId, $userId, 2, $event);

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
    private function createId($data, $placeHolder, $disabled, $event) {
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
        switch ($event) {
            case $this->ACTION_NEW:
                $id = "";
                $disabled = "disabled";
                $show = 0;
                break;                
            case $this->ACTION_EDIT:
                $disabled = "disabled";
                break;                
            case $this->ACTION_DELETE:
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