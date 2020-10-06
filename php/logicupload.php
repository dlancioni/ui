<?php
    class LogicUpload extends Base {

        // Private members
        private $cn = 0;
        private $file = "";
        private $fileName = "";
        private $fileSize = "";
        private $destination = "./php/files/";
        public $messageService = "";

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
        }

        /*
         * Upload files
         */
        public function uploadFiles($files) {

            // General Declaration
            $sql = "";
            $rs = "";
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();

            try {

                // Handle uploads
                for ($i=0; $i<=count($files); $i++) {
                    $this->file = $_FILES['userfile']['name'][$i];
                    $this->filename = $_FILES['userfile']['name'][$i];
                }

            } catch (Exception $ex) {

                // Keep source and error                
                $this->sqlBuilder->setError("Upload.uploadFile()", $ex->getMessage());

                // Rethrow it
                throw $ex;

            } finally {
                // Do nothing
            }
        }


        /*
         * Rename file and upload to php/files
         */
        public function move() {

            try {

                if (move_uploaded_file($file, $this->destination)) {
                    $msg = $message->getValue("A5");
                    throw new Exception($msg);
                }

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }



    } // End of class
?>