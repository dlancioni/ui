<?php
class LogicTabbed extends Base {

    // Class members
    private $cn = "";
    private $element = "";
    private $sqlBuilder = "";    

    // Constructor
    function __construct($cn, $sqlBuilder) {
        $this->cn = $cn;
        $this->sqlBuilder = $sqlBuilder;
        $this->element = new HTMLElement($this->cn);
    }

    /* 
     * Create tabbed page
     */
    public function createTabbed($cn, $tableId, $id) {

        // General declaration
        $parentTable = "";
        $parentField = "";
        $parentModule = array();

        try {

            // Create page instances
            $logicReport = new LogicReport($cn, $this->sqlBuilder, "");
            $logicForm = new LogicForm($cn, $this->sqlBuilder);

            // Keep parent modules
            $parentModule = $this->getParent($cn, $this->sqlBuilder, $tableId);
            foreach ($parentModule as $module) {
                $parentTable = $module["name"];
                $parentField = str_replace("tb_", "id_", $parentTable);
             }

        } catch (Exception $ex) {
            throw $ex;
        }

        // Return final chart
        return $html;        
    }


    /*
     * Get parent module to mount tabbed effect
     */
    private function getParent($cn, $sqlBuilder, $tableId) {

        $viewId = 0;
        $filter = "";
        $data = "";

        try {

            // Get data
            $filter = new Filter();
            $filter->add("tb_table", "id_parent", $tableId);
            $data = $sqlBuilder->executeQuery($cn, $sqlBuilder->TB_TABLE, $viewId, $filter->create());

        } catch (Exception $ex) {        
            throw $ex;
        }

        // Return it
        return $data;

    }



} // end of class
?>