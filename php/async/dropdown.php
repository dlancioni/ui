<?php
    // Start session
    session_start();

    // Include classes
    include "../page/include.php";

    // http://localhost/ui/php/async_dropdown.php?source=id_module&target=id_field&value=1

    // General declaration
    $db = "";
    $cn = "";   
    $id = "";
    $ds = "";    
    $key = "";
    $value = "";    
    $json = [];
    $viewId = 0;
    $data = "{}";
    $jsonUtil = "";
    $sqlBuilder = "";    
    $fieldName = "";
    $fieldValue = "";
    $tableName = "";
    $stringUtil = new StringUtil();    

    // Core code
    try {

        // Start array
        array_push($json, array('key'=>0, 'value'=>'Selecionar'));

        // Current module
        if (isset($_REQUEST["fieldName"])) {
            $fieldName = $_REQUEST["fieldName"];
        }        

        if (isset($_REQUEST["fieldValue"])) {
            $fieldValue = $_REQUEST["fieldValue"];
        }

        if (isset($_REQUEST["tableName"])) {
            $tableName = $_REQUEST["tableName"];
        }

        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
        }

        if (isset($_REQUEST["ds"])) {
            $ds = $_REQUEST["ds"];
        }

        // DB interface
        $db = new Db();       
        $jsonUtil = new JsonUtil();

        // Open connection
        $cn = $db->getConnection($_SESSION["_SYSTEM_"]);

        // Keep instance of SqlBuilder for current session
        $sqlBuilder = new SqlBuilder($_SESSION["_SYSTEM_"],
                                     $_SESSION["_MODULE_"], 
                                     $_SESSION["_USER_"],
                                     $_SESSION["_GROUP_"]);

        // Figure out module id/name
        $filter = new Filter();
        $filter->add("tb_module", "name", $tableName);
        $data = $sqlBuilder->executeQuery($cn, $sqlBuilder->TB_MODULE, $viewId, $filter->create());
        foreach ($data as $item) {
            $moduleId = $data[0]["id"];
        }                                     

        // Query data using table figured out in previous step                                  
        $filter = new Filter();
        $filter->add($tableName, $fieldName, $fieldValue);
        $data = $sqlBuilder->executeQuery($cn, $moduleId, $viewId, $filter->create());
        foreach ($data as $item) {
            array_push($json, array('key'=>$item[$id], 'value'=>$item[$ds]));
        }

    } catch (Exception $ex) {        
        throw $ex;
    }

    // Close connection
    if ($cn) {
        pg_close($cn); 
    }    

    // Return results
    echo json_encode($json);
?>