<?php
    class LogicMenu extends Base {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;
        public $html = "";

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
            $rs = "";
            $tree = "";

            try {

                // Get transactions applying access control
                $rs = $this->getData($systemId, $userId);

                // Data to treeview
                $tree = $this->prepareTree($rs);

                // Treeview to html
                $this->writeTree($tree);

            } catch (Exception $ex) {
                throw $ex;
            }
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
        * Get table definition
        */
        private function getData($systemId, $userId) {

            // General declaration    
            $rs = "";
            $sql = "";
            $db = new Db();

            try {

                // Query menus and modules
                $sql .= " select * from";
                $sql .= " (";

                    // Modules
                    $sql .= " select";
                    $sql .= " tb_table.id,";
                    $sql .= " (tb_table.field->>'id_menu')::int as id_parent,";
                    $sql .= " tb_table.field->>'name' as name";
                    $sql .= " from tb_table";
                    $sql .= " inner join tb_profile_table on (tb_profile_table.field->>'id_table')::int = tb_table.id";
                    $sql .= " inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id";
                    $sql .= " inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id";
                    $sql .= " where (tb_table.field->>'id_system')::int = " . $systemId;
                    $sql .= " and (tb_user_profile.field->>'id_user')::int = " . $userId;

                    $sql .= " union";
                    
                    // Menus within transactions
                    $sql .= " select"; 
                    $sql .= " tb_menu.id,";
                    $sql .= " (field->>'id_parent')::int as id_parent,";
                    $sql .= " (field->>'name')::text as name";
                    $sql .= " from tb_menu";
                    $sql .= " where (field->>'id_system')::int = ". $this->sqlBuilder->getSystem();
                    $sql .= " and tb_menu.id in"; 
                    $sql .= " (";
                        $sql .= " select"; 
                        $sql .= " (field->>'id_menu')::int";
                        $sql .= " from tb_table";
                        $sql .= " where (field->>'id_system')::int = ". $this->sqlBuilder->getSystem(); 
                    $sql .= " )";
                $sql .= " ) tb";
                $sql .= " order by 1";

                // Execute query
                $rs = $db->queryJson($this->cn, $sql);

            } catch (Exception $ex) {

                // Set error
                $this->setError("QueryBuilder.getTableDef()", $ex->getMessage());
            }

            // Return data
            return $rs;
        }


        /*
         * End of class   
         */    
    }
?>