<?php

    if (isset($_SESSION["_AUTH_"]) == false || $_SESSION["_AUTH_"] == 0) {
        ?>    
            <div class="form-row">
                <div class="col">
                    <input type="text" id="_SIGNID_" name="_SIGNID_" class="form-control form-control-sm" placeholder="Cód. Assinante" value="123">
                </div>        
                <div class="col">
                    <input type="text" id="_USERNAME_" name="_USERNAME_" class="form-control form-control-sm" placeholder="Usuário" value="david">
                </div>
                <div class="col">
                    <input type="password" id="_PASSWORD_" name="_PASSWORD_" class="form-control form-control-sm" placeholder="Senha" value="senha">
                </div>
                <div class="col">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="button" aria-pressed="false" onclick="login()">
                    Entrar
                    </button>
                </div>
            </div>
        <?php

    } else {
        ?>    

        <?php    
    }

?>