<?php
    class Menu extends Base {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;
        public $html;

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
        }

        /*
         * Create main menu
         */
        public function createMenu($systemId, $userId) {

            // General Declaration            
            $html = "";
            $menu = "";
            $table = "";
            $output = "";
            $stringUtil = new StringUtil();

            try {

                // Get transactions applying access control
                $filter = new Filter();
                $filter->add("tb_table", "id_system", $systemId);
                $filter->add("tb_user_profile", "id_user", $userId);
                $table = $this->sqlBuilder->executeView($this->cn, 1, $filter->create());

                // Transform data in treeview structure
                $x = $this->prepareTree($table);

                // Write the tree
                $this->writeTree($x);

            } catch (Exception $ex) {
                throw $ex;
            }

            // Return main menu
            return $html;
        }

        /*
         * Prepare tree format data to generate menu
         */
        private function prepareTree(array $elements, $parentId = 0) {

            $branch = array();
        
            foreach ($elements as $element) {
                if ($element['id_parent'] == $parentId) {
                    $children = $this->prepareTree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }
            return $branch;
        }

        /*
         * Create html menu
         */        
        public function writeTree($array)
        {
            // General Declaration
            $id = 0;

            // Create main menu
            $this->append("<ul class='fa-ul'>");
            

            foreach($array as $k => $v) {
                if (is_array($v)) {
                    $this->writeTree($v);
                    continue;
                }

                if ($k == "id") 
                    $id = $v; // temporario

                if ($k == "name") 
                    $this->append($this->createLink($id, $v));
            }
        
            $this->append("</ul>");
        }

        /*
         * Add link to current menu
         */
        private function createLink($id, $label) {
            $html = "";
            $html .= "<li>";
            $html .= "<span class='fa-li'><i class='fa fa-angle-right'></i></span>";            
            $html .= "<a onclick='go(" . $id . ", 1)'>" . $label . "</a>" . "&nbsp;&nbsp;";
            $html .= "</li>";
            return $html;
        }

        /*
         * Just append data
         */        
        private function append($html) {
            $this->html .= $html;         
        }

        /*
         * End of class   
         */    
    }
?>