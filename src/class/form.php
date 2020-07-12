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

            // Keep instance of SqlBuilder for current session
            $sqlBuilder = new SqlBuilder($this->getSystem(), $this->getTable(), $this->getUser(), $this->getLanguage());

            // Get table structure
            $tableDef = json_decode($sqlBuilder->getTableDef("json"), true);

            // Get data
            $filter = new Filter();
            $filter->add($tableDef[0]["table_name"], "id", $id);
            $sql = $sqlBuilder->getQuery($filter->create());
            $data = $db->queryJson($sql);


            /*
            // Create main form
            $html .= `<form id="form1">`;
            for ($i in tableDef) {
                fieldLabel = tableDef[i].field_label;
                fieldName = tableDef[i].field_name;
                if ($data.length > 0)
                    fieldValue = $data[0][fieldName];
                $html .= element.createLabel(fieldLabel, fieldName);
                if (tableDef[i]["field_fk"] == 0) {
                    $html .= element.createTextbox(fieldName, fieldValue, '', false);
                } else {
                    $data = JSON.parse(http.query(tableDef[i]["field_fk"], '[]'));
                    $html .= element.createDropdown(fieldName, fieldValue, $data);
                }
                $html .= '<br>';
            }
            $html .= `</form>`;
            */

            // Return table
            $html = $data;

        } catch (Exception $ex) {        
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        } finally {
                
        }

        return $html;
    }
}
?>