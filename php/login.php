<?php
if ($_SESSION["_AUTH_"] == 0) {
    ?>    
        <form>
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control form-control-sm" placeholder="Cód. Assinante">
                </div>        
                <div class="col">
                    <input type="text" class="form-control form-control-sm" placeholder="Usuário">
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-sm" placeholder="Senha">
                </div>
                <div class="col">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="button" aria-pressed="false">
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