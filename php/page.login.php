<?php

  $systemId = "forms"; // temporario apagar

    if (isset($_SESSION["_AUTH_"]) == false || $_SESSION["_AUTH_"] == 0) {
        ?>  

            <!-- Left side itens -->        
            <div class="col-12 text-right">
                <!-- Button trigger modal -->
                <a href="#" class="" data-toggle="modal" data-target="#modalRegister">Cadastre-se</a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" class="" data-toggle="modal" data-target="#modalForgetPassword">Esqueci a senha</a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" class="" data-toggle="modal" data-target="#modalLogin">Entrar</a>
            </div>

        <?php

    } else {

        ?>    
            <!-- Left side itens -->        
            <div class="col-12 text-right">
                <?php echo $systemId ?>
                &nbsp;
                <?php echo $username ?>
                &nbsp;&nbsp;&nbsp;
                <a href="#" onclick="logout()">Encerrar</a>
            </div>

        <?php    
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
                    <input type="email" id="email" name="email" class="form-control" placeholder="Informe seu e-mail" value="">
                </div>
            </div>
            <!-- Footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="register(document.getElementById('name').value, document.getElementById('email').value)" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>



<!-- Forget password -->
<div class="modal fade" id="modalForgetPassword" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Informe email onde a senha será enviada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Body -->
            <div class="modal-body">
                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Informe seu e-mail" value="">
                </div>
            </div>
            <!-- Footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="forgetPassword(document.getElementById('code').value, document.getElementById('email').value)" data-dismiss="modal">Ok</button>
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