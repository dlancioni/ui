<?php

    // General declaration
    $os = new OS();

    // Before login
    if (isset($_SESSION["_AUTH_"]) == false || $_SESSION["_AUTH_"] == 0) {

        // Standard user for development
        if ($os->getOS() == $os->WINDOWS) {
            $systemId = "empresa";
            $username = "usuario";
            $password = "123";
        } else {
            $systemId = "";
            $username = "";
            $password = "";
        }

        ?>  
            <!-- Register -->
            <div class="modal fade" id="modalRegister" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">
                                Cadastre-se e recebe os dados de acesso em seu e-mail
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Informe seu nome" value="">
                                <br>
                                <input type="text" id="email" name="email" class="form-control" placeholder="Informe seu e-mail" value="">
                                <br>
                                <input type="text" id="system" name="system" class="form-control" placeholder="Crie um código de acesso" value="">
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="register(field('name').value, field('email').value, field('system').value)" data-dismiss="modal">Ok</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Retrieve password -->
            <div class="modal fade" id="modalRetrieveCredential" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">
                                Informe o seu endereço de email
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" id="mail" name="mail" class="form-control" placeholder="Informe seu e-mail" value="">
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="retrieveCredential(field('mail').value)" data-dismiss="modal">Ok</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login -->
            <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Seja bem vindo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" id="_SYSTEM_" name="_SYSTEM_" class="form-control" placeholder="Cód. Assinante" value="<?php echo $systemId ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" id="_USERNAME_" name="_USERNAME_" class="form-control" placeholder="Usuário" value="<?php echo $username ?>">
                            </div>
                            <div class="form-group">
                                <input type="password" id="_PASSWORD_" name="_PASSWORD_" class="form-control" placeholder="Senha" value="<?php echo $password ?>">
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="login()" data-dismiss="modal">Ok</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php

        include "custom/home.php";

    } else {

        ?>    
        <!-- Left side itens -->        
        <div class="col-12 text-right">
            <a href="#" class="" data-toggle="modal" data-target="#modalPanel">Painel</a>
            &nbsp;
            <?php
                // Print system Id
                if ($os->getOS() == $os->WINDOWS) {
                    echo $db->environment . $systemId;
                } else {
                    echo $systemId;
                }
             ?>
            &nbsp;
            <?php 
                // Current user
                echo $username 
            ?>
            &nbsp;
            <a href="#" onclick="logout()">Encerrar</a>
        </div>

        <?php    
    }    
?>
