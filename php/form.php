<?php
class Form extends Base {

    /* 
    * Create new form
    */
    function createForm($id) {

        // General Declaration
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
        $key = "";
        $value = "";

        try {

            // DB interface
            $db = new Db();
            $element = new HTMLElement();

            // Keep instance of SqlBuilder for current session
            $sqlBuilder = new SqlBuilder($this->getSystem(), 
                                         $this->getTable(), 
                                        $this->getUser(), 
                                        $this->getLanguage());

            // Get table structure
            $tableDef = $sqlBuilder->getTableDef("json");

            // Get data
            $filter = new Filter();
            $filter->add($tableDef[0]["table_name"], "id", $id);
            $sql = $sqlBuilder->getQuery($filter->create());
            $data = $db->queryJson($sql);

            if ($data) {
                $html .= $element->createLabel("id", "id");
                $html .= $element->createTextbox("id", $data[0]["id"], "", true);
                $html .= "<br>";                
            }

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
                    $html .= $element->createTextbox($fieldName, $fieldValue, "");
                } else {
                    if ($fk == 4) {
                        $key = "key";
                        $value = "value";
                    } else {
                        $key = "id";
                        $value = $item["field_fk"];
                    }
                    $sql = $sqlBuilder->getQuery($fk);
                    $dataFk = $db->queryJson($sql);
                    $html .= $element->createDropdown($fieldName, 
                                                      $fieldValue, 
                                                      $dataFk, 
                                                      $key, 
                                                      $value);
                }
                $html .= "<br>";
            }

            // Finalize form
            $html .= `</form>`;

            // Get events (buttons)
            $html .= "<br>";
            $filter = new Filter();
            $filter->add("tb_event", "id_target", 2);
            $filter->add("tb_event", "id_table", $id);
            $sql = $sqlBuilder->getQuery(5, $filter->create());
            $data = $db->queryJson($sql); 
            
            foreach ($data as $item) {
                $html .= $element->createButton($item["label"], 
                                                $item["label"], 
                                                $item["id_event"],
                                                $item["code"]);
            }

        } catch (Exception $ex) {
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        } finally {
                
        }
        return $html;
    }
}
?>