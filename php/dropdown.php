<?php
    // Start session
    session_start();

    // Include classes
    include "include.php";

    // http://localhost/ui/php/dropdown.php?source=id_table&target=id_field&value=1

    // General declaration
    $db = "";
    $cn = "";
    $sqlBuilder = "";
    $jsonUtil = "";
    $data = "{}";
    $idTableFk = "";
    $tableFk = "";
    $key = "";
    $value = "";
    $source = "";
    $target = "";
    $sourceValue = "";
    $json = [];
    $tableDef = "";
    $stringUtil = new StringUtil();

    // Core code
    try {

        // Start array
        array_push($json, array('key'=>0, 'value'=>'Select'));

        // Current module
        if (isset($_REQUEST["source"])) {
            $source = $_REQUEST["source"];
        }
        if (isset($_REQUEST["target"])) {
            $target = $_REQUEST["target"];
        }
        if (isset($_REQUEST["value"])) {
            $sourceValue = $_REQUEST["value"];
        }

        // Handle _fk
        $source = str_replace("_fk", "", $source);
        $target = str_replace("_fk", "", $target);

        // DB interface
        $db = new Db();       
        $jsonUtil = new JsonUtil();

        // Open connection
        $cn = $db->getConnection();        

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder($_SESSION["_SYSTEM_"],
                                     $_SESSION["_TABLE_"], 
                                     $_SESSION["_USER_"],
                                     $_SESSION["_GROUP_"]);

        // Query table and fields used to populate dropdown                                     
        $filter = new Filter();
        $filter->add("tb_field", "name", $target);
        $data = $sqlBuilder->Query($cn, 3, $filter->create(), false);
        if ($data) {
            $idTableFk = $data[0]["id_table_fk"];
            //$tableFk = $data[0]["table_fk"];
            $key = "id";
            //$value = $data[0]["field_fk"];
        }

        $tableDef = $sqlBuilder->getTableDef($cn);
        $key = "id";

        $tableFk = $tableDef[8]["table_fk"];
        $value = $tableDef[9]["id_fk"]; 

        // Query data using table figured out in previous step                                  
        $filter = new Filter();
        $filter->add($tableFk, $source, $sourceValue);
        $data = $sqlBuilder->Query($cn, $idTableFk, $filter->create());
        foreach ($data as $item) {
            array_push($json, array('key'=>$item[$key], 'value'=>$item[$value]));
        }

    } catch (Exception $ex) {        
        // Log something soon
    } finally {
        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }

    // Return results
    echo json_encode($json);

?>