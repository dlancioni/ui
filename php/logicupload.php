<?php
    class LogicUpload extends Base {

        // Private members
        private $cn = 0;
        private $file = "";
        private $fileName = "";
        private $tempFile = "";
        private $fileSize = "";
        private $fileExtension = "";
        private $destination = "C:\\Users\\david\\xampp\\htdocs\\ui\\php\\files\\";
        private $message = "";

        // Constructor
        function __construct($cn, $sqlBuilder) {
            $this->cn = $cn;
            $this->sqlBuilder = $sqlBuilder;
            $this->message = new Message($this->cn, $this->sqlBuilder);
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

                // Keep upload folder
                $this->destination = $this->getUploadPath();

                // Handle uploads
                //for ($i=0; $i<=count($files); $i++) {
                $this->file = $_FILES['file'];
                $this->tempFile = $this->file['tmp_name'];
                $this->fileName = $this->file['name'];
                $this->fileSize = $this->file['size'];
                $this->destination = $this->destination . basename($this->fileName);
                $this->fileExtension = strtolower(pathinfo($this->destination, PATHINFO_EXTENSION));

                // Move file to destination folder
                $this->move();
                //}

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

            $msg = "";

            try {

                if (!move_uploaded_file($this->tempFile, $this->destination)) {
                    $msg = $this->message->getValue("A12");
                    throw new Exception($msg);
                }

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }

        /*
         * Get upload path for windows or linux
         */
        private function getUploadPath() {

            $path = "";
            $pos = 0;

            try {

                // Get slash position
                $pos = strpos(realpath('.'), "\\");

                if ($pos > 0) {
                    $path = realpath('.') . "\\files\\"; // Windows
                } else {
                    $path = realpath('.') . "/files/"; // Linux
                }

            } catch (Exception $ex) {
                throw $ex;
            }

            return $path;
        }




    } // End of class
?>