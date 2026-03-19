<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/global.css">

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
  </style>
</head>

<body>

  <div class="logo">
    <img src="../includes/gameviewlogo.png">
  </div>

  <div class="logincaixa">
<form class="container">

  <input type="hidden" id="token" value="<?php echo $_GET['token']; ?>"> 

  <div class="form-group">
    <label for="senha">Senha</label>
    <div class="input-group mb-3">
      <input type="password" class="form-control senha" placeholder="Senha" id="senha">
    </div>
  </div>

  <div class="form-group">
    <label for="confirma">Confirme a senha</label>
    <input type="password" class="form-control senha" id="confirma" placeholder="Confirme a senha">
  </div>

  <button class="btn btn-primary" type="button"  id="confirmar">Confirmar</button>

</form>
  </div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="../scripts/script.js"></script>
</body>
</html>