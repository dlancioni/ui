<?php
class QueryBuilder extends Base {
    // Get table definition
    private function query() {

    }    
    // Get table definition
    public function getTableDef() {

        // General declaration    
        $db = "";
        $rs = "";
        $sql = "
            select
            tb_field.id,
            (tb_field.field->>'id_system')::int as id_system,
            (tb_table.field->>'table_name')::text as table_name,
            (tb_field.field->>'label')::text as field_label,
            (tb_field.field->>'name')::text as field_name,
            (tb_field.field->>'id_type')::int as field_type,
            (tb_field.field->>'size')::int as field_size,
            (tb_field.field->>'mask')::text as field_mask,
            (tb_field.field->>'id_mandatory')::int as field_mandatory,
            (tb_field.field->>'id_unique')::int as field_unique,
            (tb_field.field->>'id_fk')::int as field_fk,
            (tb_field.field->>'domain')::text as field_domain,
            case 
                when (tb_field.field->>'id_type')::int = 1 then 'int'
                when (tb_field.field->>'id_type')::int = 2 then 'float'
                when (tb_field.field->>'id_type')::int = 3 then 'text'
                when (tb_field.field->>'id_type')::int = 4 then 'date'
                when (tb_field.field->>'id_type')::int = 5 then 'boolean'
            end data_type  
            from tb_field
            inner join tb_table on (tb_field.field->>'id_table')::int = tb_table.id
            where (tb_field.field->>'id_system')::int = p1
            and (tb_field.field->>'id_table')::int = p2
        ";

        // Set parameters
        $sql = str_replace("p1", $this->getSystem(), $sql);
        $sql = str_replace("p2", $this->getTable(), $sql);

        // Execute query and return data
        try {
            $db = new Db();
            $rs = $db->query($sql);
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getTableDef()", $ex.getMessage());
        }       
        return $rs;
    }
    // Get field list
    private function getFieldList() {        
    }
    // Get from
    private function getFrom() {        
    }
    // Get join
    private function getJoin() {
    }
    // Get condition
    private function getCondition() {
    }
} // End of class
?>