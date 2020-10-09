<?php
    class LogicMenu extends Base {

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

            foreach($array as $k => $v) {
                if (is_array($v)) {
                    if (isset($v["children"])) {
                        if (count($v["children"]) > 0) {
                            $this->append($this->addMenu($v["name"]));
                        }
                    }
                    $this->writeTree($v);
                    continue;
                }

                if ($k == "id") 
                    $id = $v; // temporario
                if ($k == "name" && $array["id_parent"] != "0") 
                    $this->append($this->addMenuItem($id, $v));
            }
        }

        /*
         * Create main menu
         */
        private function addMenu($label) {

            $html = "";
            $stringUtil = new StringUtil();

            $html .= "<li class=" . $stringUtil->dqt("nav-item dropdown") . ">";
            $html .= "<a class=". $stringUtil->dqt("nav-link dropdown-toggle") . " href=" . $stringUtil->dqt("#") . "id=". $stringUtil->dqt("menu") ." data-toggle=" . $stringUtil->dqt("dropdown") . ">" . trim($label) . "</a>";
            $html .= "<div class=" . $stringUtil->dqt("dropdown-menu") . " aria-labelledby=" . $stringUtil->dqt("menu") .">";
            
            return $html;
        }

        /*
         * Create menu item
         */
        private function addMenuItem($id, $label) {

            $html = "";
            $jsonUtil = new JsonUtil();

            $html .= "<a class='dropdown-item' href='#' onclick='go(" . $id . ", 1)'>" . $label . "</a>";

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