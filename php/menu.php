<?php
    class Menu extends Base {
        /*
         * Create main menu
         */        
        public function createMenu($cn) {

            // General Declaration            
            $html = "";

            try {

                // DB interface
                $db = new Db();

                // Keep instance of SqlBuilder for current session
                $sqlBuilder = new SqlBuilder($this->getSystem(), 
                                            $this->getTable(), 
                                            $this->getUser(), 
                                            $this->getLanguage());

                // Get data
                $filter = new Filter();
                $sql = $sqlBuilder->getQuery($cn, 2, $filter->create());
                $data = $db->queryJson($cn, $sql);

                // Create main menu
                foreach ($data as $row) {
                    $html .= "<a onclick='Go(" . $row["id"] . ", 1)'>" . $row["title"] . "</a>" . "&nbsp;&nbsp;";
                }                

                // Jump line for elegance
                $html .= "<br>";

            } catch (Exception $ex) {
                throw $ex;
            }

            // Return main menu
            return $html;
        }
    }
?>