<?php
  require_once "../session_config.php"; 

  if(!isset($_SESSION['idu'])) {
    $_SESSION['redirecionar'] = $_SERVER['REQUEST_URI'];
    header("Location: frmLogin.php");
    exit();
  }

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagem'])) {

    $imagem = $_FILES['imagem'];
    $pasta = '../uploads/';
    $id = $_SESSION['idu'] ?? null;

    if (!$id) {
        die("Erro: usuário não identificado.");
    }

    if (!is_dir($pasta)) mkdir($pasta, 0755, true);

    $permitidas = ['jpg','jpeg','png','gif','webp'];
    $nomeOriginal = $imagem['name'];
    $tmp = $imagem['tmp_name'];
    $erro = $imagem['error'];

    if ($erro === 0) {
        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

        if (!in_array($extensao, $permitidas)) {
            die("Extensão não permitida.");
        }

        // Apaga fotos antigas
        foreach ($permitidas as $ext) {
            $fotoAntiga = $pasta . $id . '.' . $ext;
            if (file_exists($fotoAntiga)) unlink($fotoAntiga);
        }

        $novoNome = $id . '.' . $extensao;
        $caminho = $pasta . $novoNome;

        if (move_uploaded_file($tmp, $caminho)) {
            // Atualiza no banco
            $stmt = $conn->prepare("UPDATE usuario SET imgu = ? WHERE idu = ?");
            $stmt->execute([$caminho, $id]);

            echo "<script>console.log('Imagem enviada com sucesso!');</script>";
        } else {
            echo "<script>console.log('Erro ao mover a imagem.');</script>";
        }

    } else {
        echo "<script>console.log('Erro no upload (código $erro).');</script>";
        
    }
}







  include "../includes/Tela_base.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/perfil.css">
    <link rel="stylesheet" href="../css/cards.css">
</head>
<style>

h4{
    margin: 10px auto;
    text-align: center;
  }

  .gold{
    position: relative;
    overflow: hidden;
    background-color: #FFB100;
    box-shadow: 0 0 10px #FFB100;
    border: 2px solid #FFB100;
  }

  .gold::before {
  content: "";
  position: absolute;
  top: 0;
  left: -85%;
  width: 50%;
  height: 100%;
  background: linear-gradient(
    100deg,
    rgba(255, 255, 255, 0) 0%,
    rgba(255, 255, 255, 0.3) 50%,
    rgba(255, 255, 255, 0) 100%
  );
  transform: skewX(-45deg);
  z-index: 5;
  animation: brilho 7s infinite;
}

@keyframes brilho {
  0% { left: -105%; }
  100% { left: 155%; }
}


</style>
<body>
<h4>Perfil</h4>
<?php 
  include_once "../codigo/perfil.php";
  $resultado = dadosPerfil($_SESSION['idu']);

  echo '<input type="hidden" id="idusuario" value="'.$_SESSION['idu'].'" >';


  if ($resultado) {

      $nome = htmlspecialchars($resultado['nomeu']);
      $email = htmlspecialchars($resultado['emailu']);
      $num = $resultado['num'];


  } else {
      echo "Erro ao carregar os dados do perfil.";
      exit();
  }
  

echo "<table>
  
  <tbody>
    <tr>
      <td>Nome de usuário</td>
      <td id='nome'>$nome</td>
      <td>
        <button class='editar' id='editar'></button>
        <button class='salvar' id='salvar'></button>
        <button class='cancelar' id='cancelar'></button>
        <button class='certo' id='certo'></button>
      </td>
    </tr>
    
    <tr>
      <td>Email</td>
      <td id='email'>$email</td>
      <td>

          <button class='editar' id='novoEmail'></button>
      
      </td>
    </tr>

    <tr>
      <td>Senha</td>
      <td>*******</td>
      <td><a href='frmEsqueci.php'><button class='editar' ></button></a></td>
    </tr>

    <tr>
      <td>Avaliações feitas</td>
      <td id='total'>$num</td>
      <td></td>
    </tr>

    <tr>
      <td>Foto de perfil</td>
      <td> 
        <form method='POST' enctype='multipart/form-data' id='formUpload'>
          <input type='file' name='imagem' id='imagem' multiple accept='image/*'>
          <div class='preview' id='preview'></div>
          <button type='submit'>Enviar</button>
        </form>
      </td>
      <td></td>
    </tr>

    <tr>
    <td>Excluir sua conta</td>
      <td><button class='btn btn-outline-danger'id='deletar' >Excluir</button></td>
   
    </tr>
    
    ";
?>
    
  </tbody>
</table>

<h4>Suas Avaliações</h4>

  <div id="games">
        
    </div>
    <div id="loading">Carregando</div>

    
    

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script>

$(document).ready(function() {

  $('#novoEmail').click(function() {

            var email = $('#email').text();
            console.log("aaaaa" + email);

            $.ajax({
                url: "../codigo/verificarEmail.php",
                type: 'POST',
                data: { email: email },
                dataType: 'json',
                beforeSend: function() {
                    // Desabilita o botão de login
                    $('#novoEmail').prop('disabled', true);
                },
                success: function(response) {

                    if (response.erro) {
                        console.log("Usuário não encontrado!");
                        $('#novoEmail').prop('disabled', false);
                    } else {

                        console.log(response.resultado);

                        console.log("Abra seu email e redefina sua senha!");
                        window.location.href = "frmLogin.php";

                    }
                },
                error: function(xhr, status, error) {
                    console.log("Erro na requisição:", error);
                    $('#novoEmail').prop('disabled', false);
                }
            });
  });
    
            

    $('#salvar').hide();
    $('#cancelar').hide();
    $('#certo').hide();

    const nomeAtual = $('#nome').text();
    const nome = document.getElementById('nome');

    $('#editar').click(function() {
        
        
        nome.contentEditable = true;
        nome.focus();
        nome.textContent = "";

        $('#editar').hide();
        $('#salvar').show();
        $('#cancelar').show();

    });

    $('#cancelar').click(function() {

        $('#nome').text(nomeAtual);
        $('#editar').show();
        $('#salvar').hide();
        $('#cancelar').hide();

    });

    $('#salvar').click(function() {

        var novoNome = $('#nome').text();

        console.log(novoNome);

          $.ajax({
            url: '../codigo/alterarNome.php',
            type: 'POST',
            data: { nome: novoNome, id: $('#id').val() },
            dataType: 'json',
            success: function(response) {

                if (response.status) {
                  nome.contentEditable = false;
                    $('#nome').text(novoNome);
                    $('#editar').hide();
                    $('#salvar').hide();
                    $('#cancelar').hide();
                    $('#certo').show().delay(1500).fadeOut(function() {
                        $('#editar').show();
                        
                    });
         

                } else {

                    
                    if(response.dados == "duplicado"){
                      alert('Nome já cadastrado');
                    }else{
                      alert('Erro ao atualizar o nome. Tente novamente.');
                    }

                }

            },
            error: function(xhr, status, error) {
              console.log("Erro na requisição:");
              console.log("Status:", status);
              console.log("Erro:", error);
              console.log("Resposta do servidor:", xhr.responseText);
              alert("Erro na requisição:\n" + xhr.responseText);
            }
          });

    });

    const gamesContainer = document.getElementById('games');
    const loading = document.getElementById('loading');
    const total = parseInt(document.getElementById('total').innerText);
    let page = 0;
    let isLoading = false;

    async function acarregarJogos() {
      
      if (isLoading) return;
      isLoading = true;
      loading.style.display = 'block';

      const offset = page * 10;

      if (offset >= total) {
        console.log("Todas as análises carregadas");
        loading.style.display = 'none';
        isLoading = true;
        return;
      }

      try {
        const resposta = await fetch(`../codigo/avaPerfil.php?offset=${offset}`);

        const dados = await resposta.json();

        dados.resultado.forEach(jogo => {
          
          const div = document.createElement('div');

          div.className = 'game';

          let corNota = '';
          let classe = '';

          if(jogo.nGeral < 100) {

            corNota = jogo.nGeral == 90 ? '#1c8200ff' :
                            jogo.nGeral >= 70 ? '#bdcb00ff' :
                            jogo.nGeral >= 50 ? '#c06300ff' :
                            '#990000';
          }else{
            classe = "gold";
          }


          div.innerHTML =  `<a href="frmJogo.php?id=${jogo.idJogoApi}" style="text-decoration: none;color: inherit;cursor: default; "> 
                                <div class="card">
                <img class="img" src="${jogo.img}"  loading="lazy" alt="${jogo.nomej}" >
                                  <div class="card-body">
                                      <h5 class="card-title" >${jogo.nomej}</h5>
                                    <h3 id="nota" class="${classe}" style="display:flex; align-items:center; border-radius:10px;background-color:${corNota}; max-width: 30%;justify-content: center;aspect-ratio: 1;">${Math.round(jogo.nGeral)}</h3>
                                  </div>
                                </div> 
                              </a>`;

          
          gamesContainer.appendChild(div);
    
        });
        

        page++;
      } catch (erro) {
        console.error('Erro ao carregar jogos:', erro);
      }

      isLoading = false;
      loading.style.display = 'none';
    }


    window.addEventListener('scroll', () => {
      const scrollY = window.scrollY;
      const alturaJanela = window.innerHeight;
      const alturaTotal = document.documentElement.scrollHeight;

      if (scrollY + alturaJanela >= alturaTotal - 700) {
        acarregarJogos();
      }
    });
  

    // Primeira chamada
    acarregarJogos();

});



</script>
<script src="../scripts/perfil.js"></script>

</html>