<?php
    class Message extends Base {

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
        public function getValue($code, $value="") {

            // General Declaration            
            $html = "";
            $message = "";
            $TB_MESSAGE = 8;
            $stringUtil = new StringUtil();

            try {

                // Get data
                $filter = new Filter();
                $filter->addCondition("tb_message", "code", "text", "=", $code);
                $data = $this->sqlBuilder->Query($this->cn, $TB_MESSAGE, $filter->create());

                // Create main menu
                foreach ($data as $row) {
                    
                    $message = $row["description"];

                    if (trim($value) != "" ) {
                        $message = $stringUtil->dqt(str_replace("%", $value, $message));
                    }
                }                

            } catch (Exception $ex) {
                throw $ex;
            }

            // Return main menu
            return $message;
        }
    }
?>