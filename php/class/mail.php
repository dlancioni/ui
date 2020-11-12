<?php
    class Mail extends Base {

        function __construct() {
        }

        /* 
         * Send mail to destination
         */
        public function send($to, $subject, $body) {

            try {

                if (PATH_SEPARATOR == ":") {
                    $lb = "\r\n";
                } else {
                    $lb = "\n";
                }
                
                $headers = "MIME-Version: 1.1" . $lb;
                $headers .= "Content-type: text/plain; charset=iso-8859-1" . $lb;
                $headers .= "From: form1@form1.com.br" . $lb;
                $headers .= "Return-Path: form1@form1.com.br" . $lb;

                mail($to, $subject, $body, $headers, "-r". "form1@form1.com.br");

            } catch (exception $ex) {
                $this->setError("mail.send()", $ex->getMessage());
                echo "erro";
            }
        }

    } // End of class
?>