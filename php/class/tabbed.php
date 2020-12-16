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
        $pageTitle = "";
        $parentTable = "";
        $parentField = "";
        $parentModule = array();
        $formData = array();
        $tabDef = array();
        $tabData = array();

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

                // Get child details
                $tableId = $module["id"];

                // Prepare page call                
                $logicReport = new LogicReport($cn, $this->sqlBuilder, $formData);
                $logicReport->showTitle = false;
                $logicReport->showAction = false;
                $logicReport->showPaging = false;
                $logicReport->queryType = $this->sqlBuilder->QUERY_NO_PAGING;

                // Create output
                $report .= $logicReport->createReport($tableId, 0, "Filter", 0);
                $pageTitle = $logicReport->pageTitle;

                // Create tab definition
                $tabDef[] = array("name"=>str_replace("_", "", $module["name"]), "title"=>$pageTitle, "page"=>$report);
             }

             // Get tabbed data
             $html .= "<br><br>";
             $html .= "<div class='tab'>";
             $html .= $this->createTabbedHeader($tabDef);
             $html .= $this->createTabbedData($tabDef);
             $html .= "</div>";

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

        // General declaration
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

    /*
     * Create tab header
     */    
    private function createTabbedHeader($tabDef) {

        // General declaration
        $html = "";
        $name = "";
        $title = "";
        $class = "nav-link active";
        $stringUtil = new StringUtil();
        $lb = $stringUtil->lb();
       
        // Create tabbed control
        $html .= "<ul class='nav nav-tabs'>" . $lb;

            // Add child tabs
            foreach  ($tabDef as $item) {

                // Key fields
                $name = $item["name"];
                $title = $item["title"];

                // Create tab
                $html .= "<li class='nav-item'>" . $lb;
                $html .= "<a href='#$name' class='$class' data-toggle='tab'>$title</a>" . $lb;
                $html .= "</li>" . $lb;

                // Only first is selected
                $class = "nav-link";
            }

        // Close list    
        $html .= "</ul>" . $lb;

        // Return it
        return $html;
    }

    /*
     * Create tab contents
     */
    private function createTabbedData($tabDef) {

        // General declaration
        $name = "";
        $page = "";
        $html = "";
        $class = "tab-pane fade show active";
        $stringUtil = new StringUtil();
        $lb = $stringUtil->lb();
       
        // Create tabbed control
        $html .= "<div class='tab-content'>" . $lb;

            // Add child tabs
            foreach ($tabDef as $tab) {

                $name = $tab["name"];
                $page = $tab["page"];

                $html .= "<div class='$class' id='$name'>";
                $html .= "<p>$page</p>" . $lb;
                $html .= "</div>" . $lb;

                $class = "tab-pane fade";
            }

            // Only first is selected
            $selected = false;

        // Close list    
        $html .= "</div>" . $lb;

        // Return it
        return $html;        
    }




} // end of class
?>