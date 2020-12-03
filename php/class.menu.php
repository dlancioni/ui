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
                            if (trim($v["id_parent"]) == "0") {
                                $this->append($this->addMenu($v["name"]));
                            } else {
                                $this->append($this->addSubMenu($v["name"]));
                            }
                        }
                    }
                    $this->writeTree($v);
                    continue;
                }

                if ($k == "id") 
                    $id = $v; // temporario

                if ($k == "name" && $array["id_parent"] != "0") { 
                    if (!isset($array["children"])) {
                        $this->append($this->addMenuItem($id, $v));
                    }
                }    
            }
        }

        /*
         * Create root level (no parent)
         */
        private function addMenu($label) {

            // General Declaration
            $html = "";
            $stringUtil = new StringUtil();
            $lb = $stringUtil->lb();

            // Create menu item
            $html .= "<li class='nav-item dropdown'>" . $lb;
            $html .= "<a class='nav-link dropdown-toggle' tabindex='0' data-toggle='dropdown' data-submenu>$label</a>" . $lb;
            $html .= "<div class='dropdown-menu'>" . $lb;
            $html .= "<div class='dropdown dropright dropdown-submenu'>" . $lb;

            // Just return it
            return $html;
        }


        /*
         * Create main menu
         */
        private function addSubMenu($label) {

            // General Declaration
            $html = "";
            $stringUtil = new StringUtil();
            $lb = $stringUtil->lb();

            // Create menu item
            $html .= "</div>" . $lb;
            $html .= "<div class='dropdown dropright dropdown-submenu'>" . $lb;
            $html .= "<button class='dropdown-item dropdown-toggle' type='button'>$label</button>" . $lb;
            $html .= "<div class='dropdown-menu'>" . $lb;

            // Just return it
            return $html;
        }

        /*
         * Create menu item
         */
        private function addMenuItem($id, $label) {

            // General Declaration
            $html = "";
            $stringUtil = new StringUtil();
            $lb = $stringUtil->lb();

            // Create menu item
            $html .= "<button class='dropdown-item' type='button' onclick='go($id, 1)'>$label</button>" . $lb;

            // Just return it
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
                    $sql .= " tb_table.field->>'title' as name";
                    $sql .= " from tb_table";
                    $sql .= " inner join tb_profile_table on (tb_profile_table.field->>'id_table')::int = tb_table.id";
                    $sql .= " inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id";
                    $sql .= " inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id";
                    $sql .= " where (tb_table.field->>'id_system')::text = " . "'" . $systemId . "'";
                    $sql .= " and (tb_user_profile.field->>'id_user')::int = " . $userId;

                    $sql .= " union";
                    
                    // Menus within transactions
                    $sql .= " select"; 
                    $sql .= " tb_menu.id,";
                    $sql .= " (field->>'id_parent')::int as id_parent,";
                    $sql .= " (field->>'name')::text as name";
                    $sql .= " from tb_menu";
                    $sql .= " where (field->>'id_system')::text = " . "'" . $systemId . "'";
                    $sql .= " and tb_menu.id in"; 
                    $sql .= " (";
                        $sql .= " select"; 
                        $sql .= " (field->>'id_menu')::int";
                        $sql .= " from tb_table";
                        $sql .= " where (field->>'id_system')::text = " . "'" . $systemId . "'";
                    $sql .= " )";
                    $sql .= " or (tb_menu.field->>'id_parent')::int = 0";                    
                $sql .= " ) tb";
                $sql .= " order by 2";

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