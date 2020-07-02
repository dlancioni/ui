<?php
include "../src/util.php";
class QueryBuilder extends Base {

    /*
     * Column definition
     */
    private $ID = 0;
    private $SYSTEM_ID = 1;
    private $TABLE_NAME = 2;
    private $FIELD_LABEL = 3;
    private $FIELD_NAME = 4;
    private $FIELD_TYPE = 5;
    private $FIELD_SIZE = 6;
    private $FIELD_MASK = 7;
    private $FIELD_MANDATORY = 8;
    private $FIELD_UNIQUE = 9;
    private $FIELD_FK = 10;
    private $TABLE_FK = 11;
    private $FIELD_DOMAIN = 12;
    private $DATA_TYPE = 13;

    /*
     * Return query based on mapping
     */
    public function query() {
        // General Declaration
        $sql = "";
        $tableDef = "";
        try {
            // Get table structure
            $tableDef = $this->getTableDef();
            // Get field list
            $sql = $this->getFieldList($tableDef);
            // Get from
            $sql = $this->getFrom($tableDef);
            // Get join
            $sql = $this->getJoin($tableDef);
            // Get condition
            $sql = $this->getCondition($tableDef);
            // Return sql
            return $sql;
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.query()", $ex.getMessage());
        }
        return $rs;
    }

    /*
     * Get table definition
     */
    public function getTableDef() {
        // General declaration    
        $db = "";
        $rs = "";
        // Get table structure and related information
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
        (tb_table_fk.field->>'table_name')::text as table_fk,
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
        left join tb_table tb_table_fk on (tb_field.field->>'id_fk')::int = tb_table_fk.id       
        where (tb_field.field->>'id_system')::int = p1
        and (tb_field.field->>'id_table')::int = p2
        order by (tb_field.field->>'id_table'), (tb_field.field->>'id_field')       
        ";

        // Set parameters
        $sql = str_replace("p1", $this->getSystem(), $sql);
        $sql = str_replace("p2", $this->getTable(), $sql);
        error_log($sql);

        // Execute query and return data
        try {
            $db = new Db();
            $rs = $db->query($sql);
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getTableDef()", $ex.getMessage());
        }
        return $rs;
    }

    /*
     * Get field list
     */
    private function getFieldList($tableDef) {
        // General Declaration
        $sql = "";
        $jsonUtil = new JsonUtil();
        try {
            // Generate select list
            pg_result_seek($tableDef, 0);
            while ($row = pg_fetch_row($tableDef)) {
                $sql .= $jsonUtil->select($row[$this->TABLE_NAME], $row[$this->FIELD_NAME], $row[$this->FIELD_TYPE], $row[$this->FIELD_NAME]);
                $sql .= ",";
            }
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getFieldList()", $ex.getMessage());
        }
        return $sql;
    }

    /*
     * Get from
     */
    private function getFrom($tableDef) {
        try {
            pg_result_seek($tableDef, 0);
            while ($row = pg_fetch_row($tableDef)) {
                return " from " . $row[$this->TABLE_NAME];
            }
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getFrom()", $ex.getMessage());
        }
    }

    /*
     * Get the joins
     */
    private function getJoin($tableDef) {
        // General declaration
        $sql = "";
        $jsonUtil = new JsonUtil();        
        try {
            pg_result_seek($tableDef, 0);
            while ($row = pg_fetch_row($tableDef)) {
                if ($row[$this->FIELD_FK] > 0) {
                    $sql .= $jsonUtil->join($row[$this->TABLE_NAME], 
                                            $row[$this->FIELD_NAME], 
                                            $row[$this->TABLE_FK], 
                                            $row[$this->FIELD_DOMAIN],
                                            "id",
                                            $row[$this->FIELD_DOMAIN]);
                }
            }
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getJoin()", $ex.getMessage());
        }        
    }

    /*
     * Get conditions
     */
    private function getCondition($tableDef) {
        try {
            pg_result_seek($tableDef, 0);
            while ($row = pg_fetch_row($tableDef)) {
                echo $row[3];
            }
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getTableDef()", $ex.getMessage());
        }        
    }

} // End of class
?>