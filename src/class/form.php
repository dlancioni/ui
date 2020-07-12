<?php
class Form extends Base {

    // Generate form
    function createForm($id) {

        $html = "";
        $fieldLabel = "";
        $fieldName = "";
        $fieldType = "";
        $fieldValue = "";
        $tableDef = "";
        $data = "";
        $events = "";
        //$element = new HTMLElement();
        $filter = "";
        $db = new Db();
        $filter = "";

        try {

            // Keep instance of SqlBuilder for current session
            $sqlBuilder = new SqlBuilder($this->getSystem(), $this->getTable(), $this->getUser(), $this->getLanguage());

            // Get table structure
            $tableDef = $sqlBuilder->getTableDef("json");

            // Get data
            $filter = new Filter();
            $filter->add($this->getTable(), "id", $id);
            $sql = $sqlBuilder->getQuery($filter);
            $data = $db->queryJson($sql);

            foreach($data as $item) { //foreach element in $arr
                echo $item['id']; //etc
            }            
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

            // Get controls (events)
            filter = new Filter();
            filter.add("tb_event", "id_table", this.tableId);
            filter.add("tb_event", "id_target", 2);
            events = JSON.parse(http.query(5, filter.create()));

            $html .= `<br>`;
            for ($i in events) {
                $html .= element.createButton(events[i].label, events[i].label, events[i].id_event + "=" + events[i].code);
            }
*/
        } catch (Exception $ex) {        
            $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
        } finally {
                
        }

        return $data;
    }
}
?>