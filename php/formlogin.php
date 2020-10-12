<?php
if ($_SESSION["_AUTH_"] == 0) {
    ?>    
        <form id="form1" name="form1" action="index.php" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col">
                    <input type="text" id="_SIGNID_" name="_SIGNID_" class="form-control form-control-sm" placeholder="Cód. Assinante">
                </div>        
                <div class="col">
                    <input type="text" id="_USERNAME_" name="_USERNAME_" class="form-control form-control-sm" placeholder="Usuário">
                </div>
                <div class="col">
                    <input type="password" id="_PASSWORD_" name="_PASSWORD_" class="form-control form-control-sm" placeholder="Senha">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-sm" data-toggle="button" aria-pressed="false">
                    Entrar
                    </button>
                </div>
            </div>
        </form>
    <?php

} else {
    ?>    

    <?php    
}
?>