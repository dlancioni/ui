<?php
include "../src/util.php";
class QueryBuilder extends Base {

    /*
     * System definition
     */
    private $SYSTEM_SYSTEM = 1;
    private $SYSTEM_TABLE = 2;
    private $SYSTEM_FIELD = 3;
    private $SYSTEM_DOMAIN = 4;

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
            $sql .= $this->getFieldList($tableDef);
            // Get from
            $sql .= $this->getFrom($tableDef);
            // Get join
            $sql .= $this->getJoin($tableDef);
            // Get where
            $sql .= $this->getWhere($tableDef);            
            // Get condition
            //$sql = $this->getCondition($tableDef);
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
        (tb_table_id_fk.field->>'table_name')::text as table_fk,
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
        left join tb_table tb_table_id_fk on (tb_field.field->>'id_fk')::int = tb_table_id_fk.id
        where (tb_field.field->>'id_system')::int = p1
        and (tb_field.field->>'id_table')::int = p2
        order by tb_field.id
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
        $count = 0;
        $jsonUtil = new JsonUtil();
        $fk = "";
        $tableName = "";
        $fieldName = "";
        $fieldType = "";
        $fieldDomain = "";
        $fieldAlias = "";
        $tableFk = "";

        try {
            // Get id            
            pg_result_seek($tableDef, 0);
            $row = pg_fetch_row($tableDef);
            $sql .= "select " . trim($row[$this->TABLE_NAME]) . ".id";
            // Generate select list            
            pg_result_seek($tableDef, 0);
            while ($row = pg_fetch_row($tableDef)) {
                $fk = $row[$this->FIELD_FK];
                $tableName = $row[$this->TABLE_NAME];
                $fieldName = $row[$this->FIELD_NAME];
                $fieldType = $row[$this->DATA_TYPE];
                $fieldDomain = $row[$this->FIELD_DOMAIN];
                $tableFk = $row[$this->TABLE_FK];
                $fieldAlias = "";
                $sql .= ", ";

                if ($fk == 0) {
                    $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                } else if ($fk == $this->SYSTEM_DOMAIN) {
                    $tableName = $fieldDomain . "_" . $fieldName;
                    $fieldAlias = $fieldName;
                    $fieldName = "value";
                    $fieldType = "text";
                    $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                } else {
                    $tableName = $tableFk . "_" . $fieldName;
                    $fieldName = "name";
                    $fieldType = "text";
                    $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                }                
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
        $sql = "";
        $jsonUtil = new JsonUtil();
        try {
            pg_result_seek($tableDef, 0);
            $row = pg_fetch_row($tableDef);
            $sql .= " from " . $row[$this->TABLE_NAME];
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getFrom()", $ex.getMessage());
        }
        return $sql;
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
                                            $row[$this->FIELD_DOMAIN]);
                }
            }
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getJoin()", $ex.getMessage());
        }
        return $sql;
    }

    /*
     * Get where
     */
    private function getWhere($tableDef) {
        $sql = "";
        $jsonUtil = new JsonUtil();
        try {
            pg_result_seek($tableDef, 0);
            $row = pg_fetch_row($tableDef);
            if ($row[$this->TABLE_NAME] != "tb_system") {
                $sql .= " where " . $jsonUtil->condition($row[$this->TABLE_NAME], "id_system", "int", "=", $this->getSystem());
            }

        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getWhere()", $ex.getMessage());
        }
        return $sql;
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