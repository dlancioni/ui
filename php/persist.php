<?php
    // Include classes
    include "include.php";

    // General declaration
    $db = "";
    $tableDef = "";
    $sqlBuilder = "";
    $stringUtil = "";
    $output = $_REQUEST["name"];

    // Core code
    try {

        // DB interface
        $db = new Db();
        $stringUtil = new StringUtil();

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder($this->getSystem(), 
                                        $this->getTable(), 
                                    $this->getUser(), 
                                    $this->getLanguage());

        // Get table structure
        $tableDef = $sqlBuilder->getTableDef("json");



    } catch (Exception $ex) {        
        $html = '{"status":"fail", "error":' . $ex->getMessage() . '}';
    } finally {

    }

    echo $output;
?>