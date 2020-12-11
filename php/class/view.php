<?php
    class LogicView extends Base {

        // Private members
        private $cn = 0;

        // Constructor
        function __construct($cn) {
            $this->cn = $cn;
        }

        /*
         * Logic before persist record
         */
        public function before($old, $new) {

            // General declaration
            try {

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Logic before persist record
         */
        public function after($id, $old, $new) {

            $viewId = 0;
            $jsonUtil = new JsonUtil();

            try {

                // Get current Id
                $viewId = $jsonUtil->getValue("id_view", $old);

                // Delete it
                switch ($this->getAction()) {
                    case "Delete":
                        $this->deleteViewField($viewId);
                }

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /*
         * Private members
         */
        public function deleteViewField($viewId) {

            $rs = "";
            $sql = "";
            $affectedRows = 0;

            try {

                $sql .= " delete from tb_view_field";
                $sql .= " where " . $jsonUtil->condition("tb_view_field", "id_view", $this->TYPE_INT, "=", $viewId);
                $rs = pg_query($this->cn, $sql);
                $affectedRows = pg_affected_rows($rs);

            } catch (Exception $ex) {
                throw $ex;
            }
        }


    } // End of class
?>