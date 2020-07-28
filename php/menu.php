<?php
    class Menu extends Base {


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