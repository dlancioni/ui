<?php
    class LogicMenu extends Base {

        // Private members
        private $cn = 0;
        private $count = 0;
        private $total = 0;
        private $level = 0;

        // Public members
        public $html = "";        

        // Constructor
        function __construct($cn) {
            $this->cn = $cn;
        }

        /*
         * Create main menu
         */
        public function createMenu($systemId, $userId) {

            // General Declaration            
            $rs = "";
            $tree = "";
            $logUtil = new LogUtil();

            try {

                // Get transactions applying access control
                $rs = $this->getData($systemId, $userId);

                // Log query
                $logUtil->log("query_menu.pgsql", $this->lastQuery);

                // Data to treeview
                $tree = $this->prepareTree($rs);

                // Treeview to html
                $this->writeTree($tree);

                // Log tree
                $logUtil->log("menu.txt", $this->html);

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
        public function writeTree($array) {
            // General Declaration
            $id = 0;

            try {

                // Write top menu based on parent structure
                foreach($array as $k => $v) {

                    // Identify menu heads
                    if (is_array($v)) {
                        if (isset($v["children"])) {
                            if (count($v["children"]) > 0) {
                                if (trim($v["id_parent"]) == "0") {
                                    $this->append($this->addMenu($v["name"]));
                                    $this->level = 2;
                                } else {

                                    // Control menu breaks
                                    $this->count = 0;
                                    $this->total = -1;
                                    if (!$this->hasChildren($v)) {
                                        if (isset($v["children"])) {
                                            $this->total = count($v["children"]);
                                        }
                                    } else {
                                        $this->level ++;
                                    }

                                    // Add html menu
                                    $this->append($this->addSubMenu($v["name"]));
                                }
                            }
                        }
                        $this->writeTree($v);
                        continue;
                    }

                    // Keep current id
                    if ($k == "id") {
                        $id = $v;
                    }

                    // Write single item
                    if ($array["id_parent"] != 0) {
                        if ($k == "name") { 
                            if (!isset($array["children"])) {

                                // Add single item
                                $this->append($this->addMenuItem($id, $v));

                                // Add menu break;
                                $this->count ++;
                                if ($this->total == $this->count) {
                                    $this->append(str_repeat("</div>", $this->level));
                                }

                            }
                        }
                    }
                }

            } catch (Exception $ex) {
                throw $ex;
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
        * Get module definition
        */
        private function getData($systemId, $userId) {

            // General declaration    
            $rs = "";
            $sql = "";
            $db = new Db();
            $stringUtil = new StringUtil();
            $lb = $stringUtil->lb();
            $join = "";

            try {

                // Join used in both queries
                $join .= " inner join tb_profile_table on (tb_profile_table.field->>'id_module')::int = tb_module.id" . $lb;
                $join .= " inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id" . $lb;
                $join .= " inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id" . $lb;
                $join .= " where (tb_user_profile.field->>'id_user')::int = " . $userId . $lb;

                // Query menus and modules
                $sql .= " select * from" . $lb;
                $sql .= " (" . $lb;

                    // Modules
                    $sql .= " select" . $lb;
                    $sql .= " tb_module.id," . $lb;
                    $sql .= " (tb_module.field->>'id_menu')::int as id_parent," . $lb;
                    $sql .= " tb_module.field->>'title' as name" . $lb;
                    $sql .= " from tb_module" . $lb;
                    $sql .= $join;

                    $sql .= " union" . $lb;
                    
                    // Menus within transactions
                    $sql .= " select" . $lb;
                    $sql .= " tb_menu.id," . $lb;
                    $sql .= " (field->>'id_parent')::int as id_parent," . $lb;
                    $sql .= " (field->>'name')::text as name" . $lb;
                    $sql .= " from tb_menu" . $lb;
                    $sql .= " where tb_menu.id in" . $lb;
                    $sql .= " (" . $lb;
                        $sql .= " select" . $lb;
                        $sql .= " (tb_module.field->>'id_menu')::int" . $lb;
                        $sql .= " from tb_module" . $lb;
                        $sql .= $join;
                    $sql .= " )" . $lb;
                    $sql .= " or (tb_menu.field->>'id_parent')::int = 0" . $lb;
                $sql .= " ) tb" . $lb;
                $sql .= " order by id_parent, id" . $lb;

                // Keeep query to log
                $this->lastQuery = $sql;

                // Execute query
                $rs = $db->queryJson($this->cn, $sql);

            } catch (Exception $ex) {

                // Set error
                $this->setError("LogicMenu.getData()", $ex->getMessage());
            }

            // Return data
            return $rs;
        }

        private function hasChildren($v) {
            
            // General Declaration
            $size = 0;
            $value = false;

            // Check arrays
            $size = count($v["children"])-1;
            $value = isset($v["children"][$size]["children"]);

            // Just return it
            return $value;
        }


        /*
         * End of class   
         */    
    }
?>