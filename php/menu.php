<?php
    class Menu extends Base {

        // Private members
        private $cn = 0;
        private $sqlBuilder = 0;

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
        }

        /*
         * Create main menu
         */        
        public function createMenu() {

            // General Declaration            
            $html = "";

            try {

                // Get data
                $filter = new Filter();
                $data = $this->sqlBuilder->Query($this->cn, 2, $filter->create());

                // Create main menu
                foreach ($data as $row) {
                    $html .= "<a onclick='go(" . $row["id"] . ", 1)'>" . $row["title"] . "</a>" . "&nbsp;&nbsp;";
                }                

                // Jump line for elegance
                $html .= "<br>";

            } catch (Exception $ex) {
                throw $ex;
            }

            // Return main menu
            return $html;
        }


        /*
         * Create main menu
         */        
        public function menu() {

            // General Declaration            
            $html = "";
            $menu = "";
            $table = "";

            $TB_TABLE = 2;
            $TB_MENU = 9;
            $stringUtil = new StringUtil();


            try {

                // Get menu and table
                $filter = new Filter();
                $menu = $this->sqlBuilder->Query($this->cn, $TB_MENU, $filter->create());
                $table = $this->sqlBuilder->Query($this->cn, $TB_TABLE, $filter->create());


            } catch (Exception $ex) {
                throw $ex;
            }

            // Begin
            $html .= "<br>";
            $html .= "<div class=" . $stringUtil->dqt("menu-container") . ">";
            $html .= "<ul class=" . $stringUtil->dqt("menu clearfix") . ">";

            // Add contents
            try {

                $html .= $this->AddSubMenu();                

            } catch (Exception $ex) {
                throw $ex;
            }

            // End
            $html .= "</ul>";
            $html .= "</div>";

            // Return main menu
            return $html;
        }

        public function addSubMenu() {

            $html = "";
            $label = "Cadastros";
            $stringUtil = new StringUtil();

            $html .= "<li>";
            $html .= "<a href=" . $stringUtil->dqt("/php/index.php") . "><b>" . $label . "</b></a>";
            $html .= "<ul class=" . $stringUtil->dqt("sub-menu clearfix") .">";

            $html .= "</ul>";
            $html .= "</li>";

            return $html;
        }

        public function addMenuItem() {

            $html = "";
            $label = "Clientes";
            $stringUtil = new StringUtil();

            $html .= "<li>";
            $html .= "<a onClick=". $stringUtil->dqt("go()") . ">" . $label . "</a>";
            $html .= "</li>";

            return $html;
        }        

        /*
         * End of class   
         */    
    }
?>