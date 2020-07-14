<?php
class SqlBuilder extends Base {

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
    private $FIELD_ID_FK = 10;
    private $TABLE_FK = 11;
    private $FIELD_FK = 12;
    private $FIELD_DOMAIN = 13;
    private $DATA_TYPE = 14;

    /*
     * Return query based on mapping
     */
    public function getQuery($tableId=0, $filter="[]") {
        // General Declaration
        $sql = "";
        $tableDef = "";
        try {
            // Handle table as parameter
            if ($tableId > 0) {
                $this->setTable($tableId);
            }
            // Get table structure
            $tableDef = $this->getTableDef("rs");
            // Get field list
            $sql .= $this->getFieldList($tableDef);
            // Get from
            $sql .= $this->getFrom($tableDef);
            // Get join
            $sql .= $this->getJoin($tableDef);
            // Get where
            $sql .= $this->getWhere($tableDef);            
            // Get condition
            $sql .= $this->getCondition($filter);
            // Get ordering
            $sql .= $this->getOrderBy($tableDef);             
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.query()", $ex->getMessage());
        }
        // Return sql
        return $sql;
    }

    /*
     * Get table definition
     */
    public function getTableDef($resultType) {
        // General declaration    
        $sql = "";
        $db = "";
        $rs = "";

        // Get table structure and related information
        $sql = $this->getSqlTableDef();

        // Execute query and return data
        try {           
            $db = new Db();
            if ($resultType == "rs") {
                $rs = $db->query($sql);
            } else if ($resultType == "json") {
                $rs = $db->queryJson($sql);                
            }
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getTableDef()", $ex->getMessage());
        }

        // Return data
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
                $fk = $row[$this->FIELD_ID_FK];
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
                    $fieldAlias = $fieldName;
                    $fieldName = "name";
                    $fieldType = "text";
                    $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                }                
            }
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getFieldList()", $ex->getMessage());
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
            $this->setError("QueryBuilder.getFrom()", $ex->getMessage());
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
                if ($row[$this->FIELD_ID_FK] > 0) {
                    $sql .= $jsonUtil->join($row[$this->TABLE_NAME], 
                                            $row[$this->FIELD_NAME], 
                                            $row[$this->TABLE_FK], 
                                            $row[$this->FIELD_DOMAIN]);
                }
            }
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getJoin()", $ex->getMessage());
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
                $sql .= " where " . $jsonUtil->condition($row[$this->TABLE_NAME], 
                                                         "id_system",
                                                         "int", 
                                                         "=", 
                                                         $this->getSystem());
            }

        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getWhere()", $ex->getMessage());
        }
        return $sql;
    }

    /*
     * Get conditions
     */
    private function getCondition($filter) {
        $sql = "";
        $jsonUtil = new JsonUtil();
        try {
            if (trim($filter) != "") {
                $filter = json_decode($filter, true);
                foreach($filter as $item) {
                    $sql .= " and " . $jsonUtil->condition($item['table'], 
                                                           $item['field'], 
                                                           $item['type'],   
                                                           $item['operator'], 
                                                           $item['value'], 
                                                           $item['mask']);
                }
            }
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getCondition()", $ex->getMessage());
        }
        return $sql;
    }

    /*
     * Get ordering
     */
    private function getOrderBy($tableDef) {
        $sql = "";
        try {
            pg_result_seek($tableDef, 0);
            $row = pg_fetch_row($tableDef);
            $sql = " order by " . trim($row[$this->TABLE_NAME]) . ".id";
        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getOrderBy()", $ex->getMessage());
        }
        return $sql;
    }    

    private function getSqlTableDef() {
        $sql = "
        select
        tb_field.id,
        (tb_field.field->>'id_system')::int as id_system,
        (tb_table.field->>'name')::text as table_name,
        (tb_field.field->>'label')::text as field_label,
        (tb_field.field->>'name')::text as field_name,
        (tb_field.field->>'id_type')::int as field_type,
        (tb_field.field->>'size')::int as field_size,
        (tb_field.field->>'mask')::text as field_mask,
        (tb_field.field->>'id_mandatory')::int as field_mandatory,
        (tb_field.field->>'id_unique')::int as field_unique,
        (tb_field.field->>'id_table_fk')::int as id_fk,
        (tb_table_fk.field->>'name')::text as table_fk,
        (tb_field_fk.field->>'name')::text as field_fk,
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
        left join tb_table tb_table_fk on (tb_field.field->>'id_table_fk')::int = tb_table_fk.id
        left join tb_field tb_field_fk on (tb_field.field->>'id_field_fk')::int = tb_field_fk.id
        where (tb_field.field->>'id_system')::int = p1
        and (tb_field.field->>'id_table')::int = p2
        order by tb_field.id
        ";

        // Set parameters
        $sql = str_replace("p1", $this->getSystem(), $sql);
        $sql = str_replace("p2", $this->getTable(), $sql);

        // Return final query    
        return $sql;
    }


} // End of class
?>