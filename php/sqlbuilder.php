<?php
class SqlBuilder extends Base {

    /*
     * Paging
     */
    public $QUERY = 1;
    public $QUERY_NO_JOIN = 2;
    public $QUERY_NO_PAGING = 3;

    /*
     * Paging
     */
    public $PageSize = 0;
    public $PageOffset = 0;


    /* 
     * Query and return json
     */
    public function executeQuery($cn, $table="", $filter="[]", $queryType=1) {

        // General Declaration
        $rs = "";
        $json = "";
        $query = "";
        $sql = "";

        try {

            // Get query
            $query = $this->prepareQuery($cn, $table, $filter, $queryType);

            // Transform results to json
            $sql = "select json_agg(t) from (" . $query . ") t";

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
     * Query and return json
     */
    public function executeView($cn, $viewId="", $filter="[]", $queryType=1) {

        // General Declaration
        $i = 0;
        $old = "";
        $new = "";
        $rs = "";
        $json = "";
        $query = "";
        $sql = "";

        try {

            // Get existing record
            $filterView = new Filter();
            $filterView->add("tb_view", "id", $viewId);
            $rs = $this->executeQuery($cn, $this->TB_VIEW, $filterView->create(), $this->QUERY_NO_PAGING);
            if (count($rs) > 0) {
                $query = $rs[0]["sql"];
            }

            // Apply parameters
            $filter = json_decode($filter, true);
            foreach ($filter as $item) {
                $i ++;
                $old = "p" . $i;
                $new = $item['value'];                
                $query = str_replace($old, $new, $query);
            }

            // Transform results to json
            $sql = "select json_agg(t) from (" . $query . ") t";

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
            echo $ex->getMessage();
        }

        // Handle empty json
        if (!$json) {
            $json = "[]";
        }

        // Return rs as json
        return json_decode($json, true);
    }

    /*
     * Get table definition
     */
    public function getTableDef($cn, $tableId) {
        // General declaration    
        $sql = "";
        $rs = "";
        $db = new Db();

        try {
            // Get table structure and related information
            $sql = $this->getSqlTableDef($tableId);

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
     * Return query based on mapping
     */
    private function prepareQuery($cn, $tableId, $filter, $queryType) {

        // General Declaration
        $sql = "";
        $tableDef = "";

        try {
            // Handle table as parameter
            if ($tableId != "") {
                if (is_numeric($tableId)) {
                    $this->setTable(intval($tableId));
                }
            }
            // Get table structure
            $tableDef = $this->getTableDef($cn, $tableId);

            if (count($tableDef) > 0) {

                // Get field list
                $sql .= $this->getFieldList($tableDef, $queryType);

                // Get from
                $sql .= $this->getFrom($tableDef);

                // Get join
                if ($queryType != $this->QUERY_NO_JOIN) {
                    $sql .= $this->getJoin($tableDef);
                }

                // Get where
                $sql .= $this->getWhere($tableDef, $tableId);

                // Get condition
                $sql .= $this->getCondition($filter);

                // Get ordering
                $sql .= $this->getOrderBy($tableDef);

                // Paging control
                if ($queryType != $this->QUERY_NO_PAGING) {
                    $sql .= $this->getPaging($tableDef);
                }
            }

        } catch (Exception $ex) {
            $this->setError("QueryBuilder.query()", $ex->getMessage());
        }
        // Return sql
         return $sql;
    }

    /*
     * Get field list
     */
    private function getFieldList($tableDef, $queryType) {

        // General Declaration
        $sql = "";
        $fk = "";
        $count = 0;        
        $tableName = "";
        $fieldName = "";
        $fieldType = "";
        $fieldDomain = "";
        $fieldAlias = "";
        $tableFk = "";
        $jsonUtil = new JsonUtil();        

        try {

            // Table name
            $tableName = trim($tableDef[0]["table_name"]);

            // Get id            
            $sql .= "select ";

            // Count over pagination
            $sql .= "count(*) over() as record_count,";

            // System fields
            $sql .= $jsonUtil->select($tableName, "id_system", "int", "id_system") . ",";
            $sql .= $jsonUtil->select($tableName, "id_group", "int", "id_group") . ",";

            // Base ID            
            $sql .= trim($tableDef[0]["table_name"]) . ".id";

            // Field list
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
                if ($queryType == $this->QUERY_NO_JOIN) {
                    $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias);
                } else {
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
    private function getWhere($tableDef, $table) {

        $sql = "";
        $jsonUtil = new JsonUtil();

        try {

            // TB_SYSTEM does not have id_system (!!)
            if ($tableDef[0]["table_name"] != "tb_system" && $table <> 1) {
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
            $sql = " order by " . trim($tableDef[0]["table_name"]) . ".id";
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

    private function getSqlTableDef($tableId) {
        
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
        $sql .= " and (tb_field.field->>'id_table')::int = " . $tableId;
        $sql .= " order by tb_field.id";                

        // Return final query    
        return $sql;
    }

    /* 
     * Persist data
     */        
    public function persist($cn, $tableName, $record) {
        
        // General declaration
        $key = "";
        $sql = "";
        $rs = "";
        $msg = "";
        $message = "";
        $affectedRows = "";
        $event = $this->getEvent();
        $jsonUtil = new jsonUtil();

        // Make sure id_system is set
        $record = $jsonUtil->setValue($record, "id_system", $this->getSystem());
        $record = $jsonUtil->setValue($record, "id_group", $this->getGroup());

        // Prepare condition for update and delete
        $key .= " where " . $jsonUtil->condition($tableName, "id", "int", "=", $this->getLastId());                        
        if ($tableName != "tb_system") {
            $key .= " and " . $jsonUtil->condition($tableName, "id_system", "int", "=", $this->getSystem());
        }

        try {

            // Prepare string
            switch ($event) {

                case "New":
                    $sql = "insert into $tableName (field) values ('$record') returning id";
                    $msg = "A6";
                    break;

                case "Edit":
                    $sql .= " update $tableName set field = '$record' " . $key;
                    $msg = "A7";
                    break;

                case "Delete":
                    $sql .= " delete from $tableName " . $key;
                    $msg = "A8";
                    break;                        
            }

            // Execute statement            
            $rs = pg_query($cn, $sql);
            if (!$rs) {
                throw new Exception(pg_last_error($cn));
            }

            // Keep rows affected
            $affectedRows = pg_affected_rows($rs);                

            // Get inserted ID
            while ($row = pg_fetch_array($rs)) {
                $this->setLastId($row['id']);
            }

            // Get final message
            $message = new Message($cn, $this);
            $msg = $message->getValue($msg);

            // Success
            $this->setError("", "");
            $this->setMessage($msg);

        } catch (Exception $ex) {

            // Keep last error
            $this->setMessage("");
            $this->setError("Db.Persist()", $ex->getMessage());

        } finally {
            // Do nothing
        }
        
        // Return ID
        return $this->getLastId();
    }
} // End of class
?>