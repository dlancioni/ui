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
        $events = "";
        $filter = "";
        $tableName = "";

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
                
                $fieldLabel = $item["field_label"];
                $fieldName = $item["field_name"];
                foreach($data as $col) {
                    $fieldValue = $col[$fieldName];
                    break;
                }
                $html .= $element->createLabel($fieldLabel, $fieldName);

                if ($item["id_fk"] == 0) {
                    $html .= $element->createTextbox($fieldName, $fieldValue, "", false);
                } else {
                    //$data = JSON.parse(http.query(tableDef[i]["field_fk"], '[]'));
                    //$html .= element->createDropdown(fieldName, fieldValue, $data);
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