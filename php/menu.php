<?php
    class Menu {
        /*
         * Create main menu
         */        
        public function createMenu() {
            $html = "";
            try {
                $html .= "<a onclick='go(1)'>System</a>" + '&nbsp';
                $html .= "<a onclick='go(2)'>Table</a>" + '&nbsp';
                $html .= "<a onclick='go(3)'>Field</a>" + '&nbsp';
                $html .= "<a onclick='go(4)'>Domain</a>" + '&nbsp';
                $html .= "<a onclick='go(5)'>Event</a>" + '&nbsp';
                $html .= "<a onclick='go(6)'>Code</a>" + '&nbsp';
                $html .= "<a onclick='go(7, 2)'>Login</a>" + '&nbsp';
            } catch (Exception $ex) {
                throw $err;
            }
            return $html;
        }
    }
?>