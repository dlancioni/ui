<?php

  $systemId = "forms"; // temporario apagar

    if (isset($_SESSION["_AUTH_"]) == false || $_SESSION["_AUTH_"] == 0) {
        ?>  

            <!-- Left side itens -->        
            <div class="col-12 text-right">
                <!-- Button trigger modal -->
                <a href="#" class="" data-toggle="modal" data-target="#exampleModalCenter">
                Entrar
                </a>
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


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Seja bem vindo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="login()" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>