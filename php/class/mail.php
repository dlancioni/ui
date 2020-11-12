<?php
    class Mail extends Base {

        /* 
         * Constructor mandatory as extends base
         */
        function __construct() {
        }

        /* 
         * Send mail to destination
         */
        public function send($to, $subject, $body) {

            try {

                /*
                $to = "dlancioni@gmail.com";
                $subject = "Email automatico";
                $body = "Teste de email 100% automatico";
                */
                
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


        /* 
         * Send mail to destination
         */
        public function send2() {

            try {

                $destino = "dlancioni@gmail.com";
                $assunto = "Email automatico";
                $mensagem = "Teste de email 100% automatico";

                if (PATH_SEPARATOR ==":") {
                    $quebra = "\r\n";
                } else {
                    $quebra = "\n";
                }
                
                $headers = "MIME-Version: 1.1".$quebra;
                $headers .= "Content-type: text/plain; charset=iso-8859-1".$quebra;
                $headers .= "From: form1@form1.com.br".$quebra; //E-mail do remetente
                $headers .= "Return-Path: form1@form1.com.br".$quebra; //E-mail do remetente
                mail($destino, $assunto, $mensagem, $headers, "-r". "form1@form1.com.br");
                print "Mensagem enviada com sucesso!";

            } catch (exception $ex) {
                $this->setError("mail.send()", $ex->getMessage());
                echo "erro";
            }
        }





    } // End of class
?>