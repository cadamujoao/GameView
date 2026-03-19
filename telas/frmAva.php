<?php
require_once "../session_config.php";
if(!isset($_SESSION['idu'])) {
    $_SESSION['redirecionar'] = $_SERVER['REQUEST_URI'];
    header("Location: frmLogin.php");
    exit();
} 

require_once "../codigo/verificaAnalise.php";
$res = verificaAnalise($_GET['id'], $_SESSION['idu']);

if($res['existe']){
    

}

include "../includes/Tela_base.php";

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/global.css">
    <title>Olá, mundo!</title>

    <style>
      label{
        color: black;
      }

        .imag{
            width: 80%;      
            display: block;
            margin: 0 auto;
        }

        .navbar{
          margin-bottom: 0px;
        }

        
        
    </style>
  </head>

  <body>
    <?php 
    require_once "../conexaoApi.php";
    
echo'<form style="max-width: 900px; margin: 0 auto; padding: 30 50px; background-color:white;" id="formulario">';
echo '<h1>'.$res['jogo']['nomej'].'</h1>';
    echo '<img class="imag" src="'.$res['jogo']['img'].'" alt="aaa">';

    ?>

    
        <input type="hidden" value="<?php echo $_GET['id'] ?>" id="id">
        
        <div class="form-group">
          <label for="texto">Escreva</label>
          <textarea class="form-control" id="texto" rows="5" <?php echo $res['existe'] ? "disabled" : "" ?>> <?php echo $res['existe'] ? $res['analise']['texto'] : "" ?> </textarea>
          <span id="num"></span>
        </div>

        <div class="form-group">
          <label for="formControlRange">História</label>
          <input type="range" class="form-control-range" id="historia" min="0" max="100" <?php echo $res['existe'] ? "disabled" : "" ?> value="<?php echo $res['existe'] ? $res['analise']['nHistoria'] : "0" ?>">
          <span id="valorH"><?php echo $res['existe'] ? $res['analise']['nHistoria'] : "0" ?></span>
        </div>

        <div class="form-group">
          <label for="formControlRange">Gráficos</label>
          <input type="range" class="form-control-range" id="graficos" min="0" max="100" <?php echo $res['existe'] ? "disabled" : "" ?> value="<?php echo $res['existe'] ? $res['analise']['nGraficos'] : "0" ?>">
          <span id="valorG"><?php echo $res['existe'] ? $res['analise']['nGraficos'] : "0" ?></span>
        </div>

        <div class="form-group">
          <label for="formControlRange">Jogabilidade</label>
          <input type="range" class="form-control-range" id="jogabilidade" min="0" max="100" <?php echo $res['existe'] ? "disabled" : "" ?> value="<?php echo $res['existe'] ? $res['analise']['nJogabilidade'] : "0" ?>">
          <span id="valorJ"><?php echo $res['existe'] ? $res['analise']['nJogabilidade'] : "0" ?></span>
        </div>

        <div class="form-group">
          <label for="formControlRange">Performance</label>
          <input type="range" class="form-control-range" id="performance" min="0" max="100" <?php echo $res['existe'] ? "disabled" : "" ?> value="<?php echo $res['existe'] ? $res['analise']['nPerformance'] : "0" ?>">
          <span id="valorP"><?php echo $res['existe'] ? $res['analise']['nPerformance'] : "0" ?></span>
        </div>

        <button class="btn btn-primary" type="button" id="enviar" <?php echo $res['existe'] ? "disabled" : "" ?> >Enviar</button>
        
        <?php echo $res['existe'] ? '<button class="btn btn-success" type="button" id="editar" >Editar</button>' : "" ?>
    
        <?php echo $res['existe'] ? '<button class="btn btn-danger" type="button" id="excluir" >Excluir</button>' : "" ?>

      </form>
    

    

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script src="../scripts/analises.js"></script>  

</body>
</html>