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
        public function uploadFiles($files, $systemId, $groupId) {

            // General Declaration
            $rs = "";
            $sql = "";
            $path = "";
            $affectedRows = 0;
            $jsonUtil = new JsonUtil();
            $pathUtil = new PathUtil();
            $fileUtil = new FileUtil();

            try {

                // Upload area on server (out of project structure)
                $path = $pathUtil->getUploadPath($systemId, $groupId);
                $fileUtil->createDirectory($path);                

                // Download area (inside web server)
                $path = $pathUtil->getDownloadPath($systemId, $groupId);
                $fileUtil->createDirectory($path);                

                // Handle uploads
                foreach($_FILES as $file) {

                    // Extract file attributes
                    $this->destination = $pathUtil->getUploadPath($systemId, $groupId);
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
                    $msg = $message->getValue("M12");
                    throw new Exception($msg);
                }

            } catch (Exception $ex) {

                // Rethrow error only
                throw $ex;
            }
        }
    } // End of class
?>