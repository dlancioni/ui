<?php

    if (isset($_SESSION["_AUTH_"]) == false || $_SESSION["_AUTH_"] == 0) {
        ?>  

            <div class="form-row">
                <div class="col">
                    <input type="text" id="_SIGNID_" name="_SIGNID_" class="form-control" placeholder="Cód. Assinante" value="1">
                </div>        
                <div class="col">
                    <input type="text" id="_USERNAME_" name="_USERNAME_" class="form-control" placeholder="Usuário" value="david">
                </div>
                <div class="col">
                    <input type="password" id="_PASSWORD_" name="_PASSWORD_" class="form-control" placeholder="Senha" value="123">
                </div>
                <div class="col">
                    <button class="btn btn-outline-primary" onclick="login()">Login</button>
                </div>
            </div>
        <?php

    } else {
        ?>    
            <!-- Left side itens -->
            <div class="col-12 text-right">
                <button class="btn btn-outline-primary" onclick="logout()">Logout</button>
            </div>
        <?php    
    }

?>