<?php
class Form extends Base {

    // Generate form
    function createForm($id) {

        $db = "";
        $html = "";
        $sqlBuilder = "";
        $fieldLabel = "";
        $fieldName = "";
        $fieldType = "";
        $fieldValue = "";
        $tableDef = "";
        $data = "";
        $dataFk = "";
        $events = "";
        $filter = "";
        $tableName = "";
        $fieldKey = "";
        $fieldValue = "";

        try {

            // DB interface
            $db = new Db();
            $element = new HTMLElement();

            // Keep instance of SqlBuilder for current session
            $sqlBuilder = new SqlBuilder($this->getSystem(), $this->getTable(), $this->getUser(), $this->getLanguage());

            // Get table structure
            $tableDef = json_decode($sqlBuilder->getTableDef("json"), true);

            // Get data
            $filter = new Filter();
            $filter->add($tableDef[0]["table_name"], "id", $id);
            $sql = $sqlBuilder->getQuery($filter->create());
            $data = json_decode($db->queryJson($sql), true);

            $html .= `<form id="form1">`;            
            foreach($tableDef as $item) {
                // Keep data
                $fk = $item["id_fk"];
                $fieldLabel = $item["field_label"];
                $fieldName = $item["field_name"];
                foreach($data as $col) {
                    $fieldValue = $col[$fieldName];
                    break;
                }
                $html .= $element->createLabel($fieldLabel, $fieldName);
                // Create fields
                if ($fk == 0) {
                    $html .= $element->createTextbox($fieldName, $fieldValue, "", false);
                } else {
                    if ($fk == 4) {
                        $fieldKey = "key";
                        $fieldValue = "value";
                    } else {
                        $fieldKey = "id";
                        $fieldValue = $item["field_fk"];
                    }
                    $sql = $sqlBuilder->getQuery($fk);
                    $dataFk = json_decode($db->queryJson($sql), true);
                    $html .= $element->createDropdown($fieldName, $fieldValue, $dataFk, $fieldKey, $fieldValue);
                }
                $html .= '<br>';
            }

            // Finalize form
            $html .= `</form>`;

        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        } finally {
                
        }

        return $html;
    }
}
?>