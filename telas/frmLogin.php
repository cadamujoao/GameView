<?php 
 require_once "../session_config.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
       flex-direction: column;
      height: 100vh;
      background-color: #000000ff;
      margin: 0;
    }
    .logo {
      margin-bottom: 20px;
      text-align: center;
    }

    .logo img {
      width: 300px;
      height: auto;
    }

    .logincaixa {
      background-color: white;
      padding: 30px 40px;
      border-radius: 10px;
      width: 100%;
      max-width: 400px; 
    }

    a {
      color: black;
      text-decoration: none;
    }

    #login{
      margin-bottom: 10px;
    }
  </style>


</head>
<body>

  <div class="logo">
    <img src="../includes/gameviewlogo.png">
  </div>

  <div class="logincaixa">
    <form>
      <div class="form-group">
        <label for="email">Endereço de email</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Seu email">
      </div>

      <div class="form-group">
        <label for="senha">Senha</label>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Senha" id="senha">
          <button type="button" class="btn btn-outline-secondary" id="ver">👁</button>
        </div>
      </div>

      <div class="form-group form-check">
        <label><a href='frmCad.php'>Quero me cadastrar</a></label>
      </div>

      <div class="form-group form-check">
        <label><a href='frmEsqueci.php'>Esqueci a senha</a></label>
      </div>

      <?php 
      if(isset($_SESSION['redirecionar'])) {
        $red = $_SESSION['redirecionar'];
        unset($_SESSION['redirecionar']);
        echo "<input type='hidden' id='redirecionar' value='$red'>";
      } else {
        echo "<input type='hidden' id='redirecionar' value='frmHome.php'>";
      }
      ?>

      <button class="btn btn-primary w-100" type="button" id="login">Login</button>

      
        <label style="margin: 0 27%;"><a href='frmHome.php'>Continuar sem login</a></label>

    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../scripts/script.js"></script>
</body>
</html>