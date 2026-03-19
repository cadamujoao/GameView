<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
  </style>


</head>
<body>

  <div class="logo">
    <img src="../includes/gameviewlogo.png">
  </div>

  <div class="logincaixa">
<form class="container" method="POST">
  <div class="form-group">
    <label for="email">Nome de usuário</label>
    <input type="text" class="form-control sem-numeros sem-especiais" id="nome" placeholder="Seu nome">
  </div>

  <div class="form-group">
    <label for="email">Endereço de email</label>
    <input type="email" class="form-control" id="email" placeholder="Seu email">
  </div>

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

  <div class="form-group form-check">
    <label> <a href='frmLogin.php'>Já tenho uma conta</a></label>
  </div>

  <button class="btn btn-primary" type="button"  id="cadastrar">Cadastrar</button>

</form>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="../scripts/scriptU.js"></script>
</body>
</html>