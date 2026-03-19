<?php
require_once '../session_config.php';
if (isset($_POST['sair'])) {
    unset($_SESSION['idu']); // remove o login do usuário, mantém outras variáveis

    // Redireciona para login
    header("Location: frmLogin.php");
    exit();
}

include '../conexao.php';

if(isset($_SESSION['idu'])){
  $stmt = $conn->prepare("SELECT imgu from usuario where idu = ?;");

  try{
      $stmt->execute([$_SESSION['idu']]);
      $user = $stmt->fetch();
  }catch(Exception $ex){
      echo '<p>'. $ex->getMessage().'</p>';
  }
}

?>

<link rel="stylesheet" href='../css/cabecalho.css'>
<nav class="navbar navbar-expand-lg navbar-dark" style="position: sticky; top: 0; width: 100%; z-index: 999;">

  <a class="navbar-brand" href="../telas/frmHome.php" >
    <img src="../includes/gameviewlogo.png" width="100" alt="">
  </a>
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Alterna navegação">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <div class="menu">
      <a class="ss" href="../telas/frmHome.php">Home</a>
    </div>

  <div class="ml-auto d-flex align-items-center">

    
  
<?php

$semPesquisa = ['frmPerfil.php', 'frmJogo.php','frmAva.php'];

$pag = basename($_SERVER['PHP_SELF']);

if(!in_array($pag, $semPesquisa)){ 

  echo '<form class="form-inline my-2 my-lg-0 mr-auto pesquisa" onsubmit="return false;">
    
    <input class="form-control mr-sm-2" type="search" id="pesquisa" placeholder="Pesquisar">
    <button class="btn btn-outline-success my-2 my-sm-0" id="pesquisar" type="button"> Pesquisa </button>
  </form>';
}


if(isset($_SESSION['idu'])){
  echo '<form method="post" class="sair">
    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="sair">Sair</button>
  </form>

  <label>Olá,'. $_SESSION['nome'].'</label>';
}else{
  echo '<label><a  style="color:white; margin: auto 10px;" href="frmLogin.php">Faça login!</a></label>';
}

?>
  <a href="../telas/frmPerfil.php" class="ml-auto"> <img width="50" height="50" src="<?php echo $user['imgu'] ?? '../includes/user.png'?>" alt="user" class="aa"></a>
  </div>
</div>
</nav>
    
    