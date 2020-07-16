<?php
    class Menu {
        /*
         * Create main menu
         */        
        public function createMenu() {
            $html = "";
            try {
                $html .= "<a onclick='go(1,1)'>System</a>" . "&nbsp;&nbsp;";
                $html .= "<a onclick='go(2,1)'>Table</a>" . "&nbsp;&nbsp;";
                $html .= "<a onclick='go(3,1)'>Field</a>" . "&nbsp;&nbsp;";
                $html .= "<a onclick='go(4,1)'>Domain</a>" . "&nbsp;&nbsp;";
                $html .= "<a onclick='go(5,1)'>Event</a>" . "&nbsp;&nbsp;";
                $html .= "<a onclick='go(6,1)'>Code</a>" . "&nbsp;&nbsp;";
                $html .= "<a onclick='go(7, 2)'>Login</a>" . "&nbsp;&nbsp;";
                $html .= "<br><br>";

            } catch (Exception $ex) {
                throw $ex;
            }
            return $html;
        }
    }
?>