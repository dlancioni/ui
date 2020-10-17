<?php

    if (isset($_SESSION["_AUTH_"]) == false || $_SESSION["_AUTH_"] == 0) {
        ?>  

            <div class="form-row">
                <div class="col">
                    <input type="text" id="_SYSTEM_" name="_SYSTEM_" class="form-control" placeholder="Cód. Assinante" value="<?php echo $systemId ?>">
                </div>        
                <div class="col">
                    <input type="text" id="_USERNAME_" name="_USERNAME_" class="form-control" placeholder="Usuário" value="<?php echo $username ?>">
                </div>
                <div class="col">
                    <input type="password" id="_PASSWORD_" name="_PASSWORD_" class="form-control" placeholder="Senha" value="<?php echo $password ?>">
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