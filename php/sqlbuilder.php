<?php
class SqlBuilder extends Base {

    /*
     * Paging
     */
    public $PageSize = 0;
    public $PageOffset = 0;

    /* 
     * Query and return json
     */
    public function Query($cn, $table="", $filter="[]", $joinTable=true) {

        // General Declaration
        $rs = "";
        $json = "";
        $query = "";
        $sql = "";

        try {

            // Get query
            $query = $this->getQuery($cn, $table, $filter, $joinTable);

            // Transform results to json
            $sql = "select json_agg(t) from (" . $query . ") t";

            // Log query
            error_log($sql);

            // Execute query
            $rs = pg_query($cn, $sql);
            $this->setError("", "");

            // Return data
            while ($row = pg_fetch_row($rs)) {
                $json = $row[0];
                break;
            }
        } catch (exception $ex) {                
            $this->setError("db.queryJson()", pg_last_error($cn));
        }

        // Handle empty json
        if (!$json) {
            $json = "[]";
        }

        // Return rs as json
        return json_decode($json, true);
    }     

    /*
     * Return query based on mapping
     */
    public function getQuery($cn, $table, $filter, $joinTable) {
        // General Declaration
        $sql = "";
        $tableDef = "";
        try {
            // Handle table as parameter
            if ($table != "") {
                if (is_numeric($table)) {
                    $this->setTable(intval($table));
                }
            }
            // Get table structure
            $tableDef = $this->getTableDef($cn);

            if (count($tableDef) > 0) {  
                // Get field list
                $sql .= $this->getFieldList($tableDef, $joinTable);
                // Get from
                $sql .= $this->getFrom($tableDef);
                // Get join
                if ($joinTable)
                    $sql .= $this->getJoin($tableDef);
                // Get where
                $sql .= $this->getWhere($tableDef);            
                // Get condition
                $sql .= $this->getCondition($filter);
                // Get ordering
                $sql .= $this->getOrderBy($tableDef);
                // Paging control
                $sql .= $this->getPaging($tableDef);
            }

        } catch (Exception $ex) {
            $this->setError("QueryBuilder.query()", $ex->getMessage());
        }
        // Return sql
        return $sql;
    }

    /*
     * Get table definition
     */
    public function getTableDef($cn) {
        // General declaration    
        $sql = "";
        $rs = "";
        $db = new Db();

        try {
            // Get table structure and related information
            $sql = $this->getSqlTableDef();

            // Execute query
            $rs = $db->queryJson($cn, $sql);

        } catch (Exception $ex) {

            // Set error
            $this->setError("QueryBuilder.getTableDef()", $ex->getMessage());
        }

        // Return data
        return $rs;
    }

    /*
     * Get field list
     */
    private function getFieldList($tableDef, $joinTable) {
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
            $sql .= "select ";
            $sql .= trim($tableDef[0]["table_name"]) . ".id,";
            $sql .= "count(*) over() as record_count";

            // Generate select list            
            foreach ($tableDef as $row) {

                // Keep info
                $sql .= ", ";
                $tableName = $row["table_name"];
                $fieldName = $row["field_name"];
                $fieldType = $row["data_type"];
                $fieldDomain = $row["field_domain"];
                $tableFk = $row["table_fk"];
                $fieldFk = $row["field_fk"];
                $fk = $row["id_fk"];
                $fieldAlias = "";

                // Create dropdown
                if ($joinTable) {
                    if ($fk == 0) {
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                    } else if ($fk == 4) {
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                        $sql .= ", ";
                        $fieldAlias = substr($fieldName, 3);
                        $tableName = $fieldDomain . "_" . $fieldName;
                        $fieldName = "value";
                        $fieldType = "text";
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                    } else {
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                        $sql .= ", ";
                        $fieldAlias = substr($fieldName, 3);                    
                        $tableName = $tableFk . "_" . $fieldName;
                        $fieldName = $fieldFk;
                        $fieldType = "text";
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                    }
                } else {
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
            $sql .= " from " . $tableDef[0]["table_name"];
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
            foreach ($tableDef as $row) {
                if ($row["id_fk"] > 0) {
                    $sql .= $jsonUtil->join($row["table_name"], 
                                            $row["field_name"], 
                                            $row["table_fk"], 
                                            $row["field_domain"]);
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
            if ($tableDef[0]["table_name"] != "tb_system") {
                $sql .= " where " . $jsonUtil->condition($tableDef[0]["table_name"], 
                                                         "id_system",
                                                         "int", 
                                                         "=", 
                                                         $this->getSystem());
            } else {
                $sql = " where 1 = 1";
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
                foreach ($filter as $item) {
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

    /*
     * Get paging
     */
    private function getPaging($tableDef) {
        $sql = "";
        try {

            // Page size
            if ($this->PageSize > 0) {
                $sql .= " limit $this->PageSize";
            }

            // Page Offset
            if ($this->PageOffset > 0) {
                $sql .= " offset $this->PageOffset";
            }

        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getOrderBy()", $ex->getMessage());
        }
        return $sql;
    }        

    private function getSqlTableDef() {
        
        $sql = "";
        $sql .= " select";
        $sql .= " tb_field.id,";
        $sql .= " (tb_field.field->>'id_system')::int as id_system,";
        $sql .= " (tb_table.field->>'table_name')::text as table_name,";
        $sql .= " (tb_table.field->>'name')::text as name,";
        $sql .= " (tb_field.field->>'label')::text as field_label,";
        $sql .= " (tb_field.field->>'name')::text as field_name,";
        $sql .= " (tb_field.field->>'id_type')::int as field_type,";
        $sql .= " (tb_field.field->>'size')::int as field_size,";
        $sql .= " (tb_field.field->>'mask')::text as field_mask,";
        $sql .= " (tb_field.field->>'id_mandatory')::int as field_mandatory,";
        $sql .= " (tb_field.field->>'id_unique')::int as field_unique,";
        $sql .= " (tb_field.field->>'id_table_fk')::int as id_fk,";
        $sql .= " (tb_table_fk.field->>'table_name')::text as table_fk,";
        $sql .= " (tb_field_fk.field->>'name')::text as field_fk,";
        $sql .= " (tb_field.field->>'domain')::text as field_domain,";        
        $sql .= " case ";
        $sql .= " when (tb_field.field->>'id_type')::int = 1 then 'int'";
        $sql .= " when (tb_field.field->>'id_type')::int = 2 then 'float'";
        $sql .= " when (tb_field.field->>'id_type')::int = 3 then 'text'";
        $sql .= " when (tb_field.field->>'id_type')::int = 4 then 'date'";
        $sql .= " when (tb_field.field->>'id_type')::int = 5 then 'time'";
        $sql .= " when (tb_field.field->>'id_type')::int = 6 then 'text'";        
        $sql .= " end data_type";  
        $sql .= " from tb_field";
        $sql .= " inner join tb_table on (tb_field.field->>'id_table')::int = tb_table.id";
        $sql .= " left join tb_table tb_table_fk on (tb_field.field->>'id_table_fk')::int = tb_table_fk.id";
        $sql .= " left join tb_field tb_field_fk on (tb_field.field->>'id_field_fk')::int = tb_field_fk.id";
        $sql .= " where (tb_field.field->>'id_system')::int = " . $this->getSystem();
        $sql .= " and (tb_field.field->>'id_table')::int = " . $this->getTable();
        $sql .= " order by tb_field.id";                

        // Return final query    
        return $sql;
    }





} // End of class
?>