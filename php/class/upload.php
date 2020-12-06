<?php
    class LogicUpload extends Base {

        // Private members
        private $cn = 0;
        private $file = "";
        private $fileName = "";
        private $tempFile = "";
        private $fileSize = "";
        private $fileExtension = "";

        // Constructor
        function __construct($cn) {
            $this->cn = $cn;            
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
            $pathUtil = new PathUtil();

            try {

                // Handle uploads
                foreach($_FILES as $file) {

                    // Extract file attributes
                    $this->destination = $pathUtil->getUploadPath();
                    $this->tempFile = $file['tmp_name'];
                    $this->fileName = $file['name'];
                    $this->fileSize = $file['size'];
                    $this->destination = $this->destination . basename($this->fileName);
                    $this->fileExtension = strtolower(pathinfo($this->destination, PATHINFO_EXTENSION));

                    // Move file to destination folder
                    if (trim($this->tempFile) != "") {
                        $this->move();
                    }
                }

            } catch (Exception $ex) {

                // Keep source and error                
                $this->setError("Upload.uploadFiles()", $ex->getMessage());

                // Rethrow it
                throw $ex;
            }
        }


        /*
         * Rename file and upload to php/files
         */
        public function move() {

            $msg = "";
            $message = new Message($this->cn);

            try {

                if (!move_uploaded_file($this->tempFile, $this->destination)) {
                    $msg = $message->getValue("A12");
                    throw new Exception($msg);
                }

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }
    } // End of class
?>