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
     * Logging
     */    
    public $lastQuery = "";

    /*
     * Line break
     */    
    public $lb = "";    

    /* 
     * Query and return json
     */
    public function executeQuery($cn, $tableId="", $viewId="", $filter="[]", $queryType=1, $tableDef="") {

        // General Declaration
        $rs = "";
        $json = "";
        $query = "";
        $sql = "";
        $stringUtil = new StringUtil();

        try {

            // Keep separator
            $this->lb = $stringUtil->lb();

            // Get query
            $query = $this->prepareQuery($cn, $tableId, $viewId, $filter, $queryType, $tableDef);

            // Transform results to json
            $sql = "select json_agg(t) from (" . $query . ") t";

            // Log file
            $this->lastQuery = $sql;

            // Execute query
            $rs = pg_query($cn, $sql);
            $this->setError("", "");

            // Return data
            while ($row = pg_fetch_row($rs)) {
                $json = $row[0];
                break;
            }
        } catch (exception $ex) {                
            $this->setError("sqlbuilder.queryJson()", $ex->getMessage());
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
    public function getTableDef($cn, $tableId, $viewId) {
        
        // General declaration    
        $sql = "";
        $rs = "";
        $db = new Db();
        $logUtil = new LogUtil();        

        try {

            // Get table structure and related information
            if ($viewId != "") {
                $sql = $this->getSqlViewDef($viewId);
            } else {
                $sql = $this->getSqlTableDef($tableId);
            }

            // Keep last query
            $this->lastQuery = $sql;

            // Execute query
            $rs = $db->queryJson($cn, $sql);

        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getTableDef()", $ex->getMessage());
        }

        // Return data
        return $rs;
    }

    /*
     * Return query based on mapping
     */
    private function prepareQuery($cn, $tableId, $viewId, $filter, $queryType, $tableDef) {

        // General Declaration
        $sql = "";

        try {

            // Handle table as parameter
            if ($tableId != "") {
                $this->setTable(intval($tableId));
            }

            // Get table structure
            if ($viewId != "") {
                $tableDef = $this->getTableDef($cn, "", $viewId);
            } else {
                if ($tableDef == "") {
                    $tableDef = $this->getTableDef($cn, $tableId, "");
                }
            }

            // Error handler
            if ($this->getError() != "") {
                $this->setError("SqlBuilder.getTableDef", $this->getError());
                throw new Exception($this->getError());
            }

            // Prepare query
            if (is_array($tableDef)) {

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
        $lb = "";
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

            // Keep separator
            $lb = $this->lb;

            // Table name
            $tableName = trim($tableDef[0]["table_name"]);

            // Get id            
            $sql .= "select " . $lb;

            // Count over pagination
            $sql .= "count(*) over() as record_count," . $lb;

            // System fields
            $sql .= $jsonUtil->select($tableName, "id_system", $this->TYPE_TEXT, "id_system") . "," . $lb;
            $sql .= $jsonUtil->select($tableName, "id_group", $this->TYPE_INT, "id_group") . "," . $lb;

            // Base ID            
            $sql .= trim($tableDef[0]["table_name"]) . ".id" . $lb;

            // Field list
            foreach ($tableDef as $row) {

                // Keep info
                $sql .= ", ";
                $tableName = $row["table_name"];
                $fieldName = $row["field_name"];
                $fieldType = $row["field_type"];
                $fieldDomain = $row["field_domain"];
                $tableFk = $row["table_fk"];
                $fieldFk = $row["field_fk"];
                $fk = $row["id_fk"];
                $fieldAlias = "";

                // Create dropdown
                if ($queryType == $this->QUERY_NO_JOIN) {
                    $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias) . $lb;
                } else {
                    if ($fk == 0) {
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias) . $lb;
                    } else if ($fk == $this->TB_DOMAIN) {
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias) . $lb;
                        $sql .= ", ";
                        $fieldAlias = substr($fieldName, 3);
                        $tableName = $fieldDomain . "_" . $fieldName;
                        $fieldName = "value";
                        $fieldType = $this->TYPE_TEXT;
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias) . $lb;
                    } else {
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias) . $lb;
                        $sql .= ", ";
                        $fieldAlias = substr($fieldName, 3);
                        $tableName = $tableFk . "_" . $fieldName;
                        $fieldName = $fieldFk;
                        $fieldType = $this->TYPE_TEXT;
                        $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias) . $lb;
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
        $lb = $this->lb;

        try {
            $sql .= " from " . $tableDef[0]["table_name"] . $lb;
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
        $lb = $this->lb;

        try {

            foreach ($tableDef as $row) {
                if ($row["id_fk"] > 0) {
                    $sql .= $jsonUtil->join($row["table_name"], 
                                            $row["field_name"], 
                                            $row["table_fk"], 
                                            $row["field_domain"]);
                    $sql .= $lb;                        
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
        $tableName = "";
        $jsonUtil = new JsonUtil();
        $lb = $this->lb;

        try {

            $tableName = $tableDef[0]["table_name"];

            $sql .= " where " . $jsonUtil->condition($tableName, 
                                                    "id_system",
                                                    $this->TYPE_TEXT, 
                                                    "=", 
                                                    $this->getSystem());
            $sql .= $lb;

            // 1-system
            // 2-admin
            // No restriction to view data for both groups
            if ($this->getGroup() > 2) {
                $sql .= " and " . $jsonUtil->field($tableName, "id_group", $this->TYPE_INT);
                $sql .= " in ";
                $sql .= " (";
                $sql .= $this->getSqlGroupIdByUser($this->getUser());
                $sql .= ") ";
                $sql .= $lb;
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
        $tableName = "";
        $fieldName = "";
        $fieldType = "";
        $fieldOperator = "";
        $fieldValue = "";
        $fieldMask = "";
        $jsonUtil = new JsonUtil();
        $lb = $this->lb;

        try {
            if (trim($filter) != "") {
                $filter = json_decode($filter, true);
                foreach ($filter as $item) {

                    // Get values
                    $tableName = $item["table"];
                    $fieldName = $item["field"];
                    $fieldType = $item["type"];
                    $fieldOperator = $item["operator"];
                    $fieldValue = $item["value"];
                    $fieldMask = $item["mask"];

                    // Create condition
                    if ($fieldType != "file") {
                        $sql .= " and " . $jsonUtil->condition($tableName, 
                                                               $fieldName, 
                                                               $fieldType,
                                                               $fieldOperator, 
                                                               $fieldValue, 
                                                               $fieldMask);
                    $sql .= $lb;                                                               
                    }
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
        $lb = $this->lb;
                

        try {
            $sql = " order by " . trim($tableDef[0]["table_name"]) . ".id";
            $sql .= $lb;
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
        $lb = $this->lb;

        try {

            // Page size
            if ($this->PageSize > 0) {
                $sql .= " limit $this->PageSize" . $lb;
            }

            // Page Offset
            if ($this->PageOffset > 0) {
                $sql .= " offset $this->PageOffset". $lb;
            }

        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getOrderBy()", $ex->getMessage());
        }
        
        return $sql;
    }

    private function getSqlTableDef($tableId) {
        
        // General declaration
        $sql = "";
        $lb = $this->lb;

        // Prepare query on table
        $sql .= " select" . $lb;

        // Field list
        $sql .= $this->getSqlFieldList();

        // Base table
        $sql .= " from tb_field" . $lb;

        // Join table
        $sql .= " inner join tb_table on (tb_field.field->>'id_table')::text = (tb_table.id)::text" . $lb;

        // Join inner table
        $sql .= " left join tb_table tb_table_fk on (tb_field.field->>'id_table_fk')::text = (tb_table_fk.id)::text" . $lb;
        $sql .= " left join tb_field tb_field_fk on (tb_field.field->>'id_field_fk')::text = (tb_field_fk.id)::text" . $lb;

        // Base filter
        $sql .= " where (tb_field.field->>'id_system')::text = " . $this->getSystem() . $lb;
        $sql .= " and (tb_field.field->>'id_table')::int = " . $tableId . $lb;

        // Ordering
        $sql .= " order by (tb_field.field->>'ordenation')::int, tb_field.id" . $lb;

        // Return final query
        return $sql;
    }


    private function getSqlViewDef($viewId) {
        
        // General declaration
        $sql = "";
        $lb = $this->lb;

        // Prepare query on table
        $sql .= " select" . $lb;

        // Field list
        $sql .= $this->getSqlFieldList();

        // Base table
        $sql .= " from tb_view" . $lb;

        // View x Fields
        $sql .= " inner join tb_view_field on (tb_view_field.field->>'id_view')::text = (tb_view.id)::text" . $lb;

        // Join fields
        $sql .= " inner join tb_field on (tb_view_field.field->>'id_field')::text = (tb_field.id)::text" . $lb;

        // Join table
        $sql .= " inner join tb_table on (tb_field.field->>'id_table')::text = (tb_table.id)::text" . $lb;

        // Join inner table
        $sql .= " left join tb_table tb_table_fk on (tb_field.field->>'id_table_fk')::text = (tb_table_fk.id)::text" . $lb;
        $sql .= " left join tb_field tb_field_fk on (tb_field.field->>'id_field_fk')::text = (tb_field_fk.id)::text" . $lb;        

        // Base filter
        $sql .= " where (tb_field.field->>'id_system')::text = " . $this->getSystem() . $lb;

        // Filter view
        $sql .= " and tb_view.id = " . $viewId . $lb;

        // Ordering
        $sql .= " order by tb_view_field.id" . $lb;

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
        $action = $this->getAction();
        $jsonUtil = new jsonUtil();
        $systemId = str_replace("'", "", $this->getSystem());

        // Make sure id_system is set
        $record = $jsonUtil->setValue($record, "id_system", $systemId);
        $record = $jsonUtil->setValue($record, "id_group", $this->getGroup());

        // Prepare condition for update and delete
        $key .= " where " . $jsonUtil->condition($tableName, "id", $this->TYPE_INT, "=", $this->getLastId());                        
        $key .= " and " . $jsonUtil->condition($tableName, "id_system", $this->TYPE_TEXT, "=", $this->getSystem());

        try {

            // Prepare string
            switch ($action) {

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
        }
        
        // Return ID
        return $this->getLastId();
    }


    /*
     * Get paging
     */
    private function getSqlGroupIdByUser($userId) {

        $sql = "";
        $jsonUtil = new JsonUtil();

        try {

            // Mandatory to access transactions (event, buttons, etc)
            $sql .= " select 1"; 

            // Join results    
            $sql .= " union";

            // Groups users are mapped
            $sql .= " select ";
            $sql .= $jsonUtil->field("tb_user_group", "id_grp", $this->TYPE_INT);
            $sql .= " from tb_user_group";
            $sql .= " where " . $jsonUtil->field("tb_user_group", "id_system", $this->TYPE_TEXT) . " = " . $this->getSystem();
            $sql .= " and " . $jsonUtil->field("tb_user_group", "id_user", $this->TYPE_INT) . " = " . $userId;

        } catch (Exception $ex) {
            $this->setError("QueryBuilder.getSqlGroupIdByUser()", $ex->getMessage());
        }
        
        return $sql;
    }


    private function getSqlFieldList() {

        // General declaration
        $sql = "";
        $lb = $this->lb;

        // Id
        $sql .= " tb_field.id," . $lb;

        // tb_table
        $sql .= " (tb_field.field->>'id_system')::text as id_system," . $lb;
        $sql .= " (tb_table.field->>'name')::text as table_name," . $lb;
        $sql .= " (tb_table.field->>'title')::text as title," . $lb;
        $sql .= " (tb_table.field->>'id_view')::text as id_view," . $lb;

        // tb_field        
        $sql .= " (tb_field.field->>'label')::text as field_label," . $lb;
        $sql .= " (tb_field.field->>'name')::text as field_name," . $lb;
        $sql .= " (tb_field.field->>'id_type')::text as field_type," . $lb;
        $sql .= " (tb_field.field->>'size')::int as field_size," . $lb;
        $sql .= " (tb_field.field->>'mask')::text as field_mask," . $lb;
        $sql .= " (tb_field.field->>'id_mandatory')::int as field_mandatory," . $lb;
        $sql .= " (tb_field.field->>'id_unique')::int as field_unique," . $lb;
        $sql .= " (tb_field.field->>'id_table_fk')::int as id_fk," . $lb;
        $sql .= " (tb_table_fk.field->>'name')::text as table_fk," . $lb;
        $sql .= " (tb_field_fk.field->>'name')::text as field_fk," . $lb;
        $sql .= " (tb_field.field->>'domain')::text as field_domain," . $lb;
        $sql .= " (tb_field.field->>'default_value')::text as default_value," . $lb;
        $sql .= " (tb_field.field->>'ordenation')::text as ordenation," . $lb;
        $sql .= " (tb_field.field->>'id_control')::text as id_control" . $lb;

        // Return it
        return $sql;
    }


} // End of class
?>