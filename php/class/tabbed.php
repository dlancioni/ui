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
        $html = "";
        $form = "";
        $report = "";
        $formData = array();
        $pageTitle = "";
        $parentTable = "";
        $parentField = "";
        $parentModule = array();

        try {

            // Create page instances
            $logicForm = new LogicForm($cn, $this->sqlBuilder);
            $logicForm->showTitle = false;
            $logicForm->showAction = false;

            // Get main form (disabled)
            $form .= $logicForm->createForm($tableId, $id, "Delete");
            $pageTitle = $logicForm->pageTitle;
            $html .= $pageTitle;
            $html .= $form;

            // Keep parent field
            $parentField = str_replace("tb_", "id_", $logicForm->tableName);
            $formData = array($parentField=>$id);            

            // Get child reports
            $parentModule = $this->getParent($cn, $this->sqlBuilder, $tableId);

            // Create tabbed effect
            foreach ($parentModule as $module) {

                // Reset values
                $report = "";
                $pageTitle = "";

                // Prepare page call
                $tableId = $module["id"];                
                $logicReport = new LogicReport($cn, $this->sqlBuilder, $formData);
                $logicReport->showTitle = false;
                $logicReport->showAction = false;
                $logicReport->showPaging = false;
                $logicReport->queryType = $this->sqlBuilder->QUERY_NO_PAGING;

                // Create output
                $report .= $logicReport->createReport($tableId, 0, "Filter", 0);
                $pageTitle = $logicReport->pageTitle;
                $html .= $pageTitle;
                $html .= $report;
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