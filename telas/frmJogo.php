<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous">
      <link rel="stylesheet" href="../css/global.css">


    <title>Detalhes do Jogo</title>

    <style>

        .imag {
            max-height: 800px;
            max-width: 80%;
            display: block;
            margin: 20px auto;
            border-radius: 10px;
        }

        #avaliacoes {
          max-width: 70%; 
          margin: 20px auto; 
          padding: 20px; 
          border-radius: 10px;
        }

        .avaliacao {
          background-color: #f9f9f9; 
          border: 1px solid #ddd; 
          border-radius: 10px;
          padding: 15px; 
          margin-bottom: 15px; 
          display: flex; 
          align-items: flex-start;
          gap: 15px;    
        }

        .avaliacao img {
          border-radius: 100%; 
          max-width: 70px;
          aspect-ratio: 1;
            object-fit: cover;
            align-items: flex-start;
        }

        .conteudo{
          display: flex;
          flex-direction: column;
           min-width: 80%;
           gap: 10px;
        }

        #avaliacoes text{
          background-color: white; 
          font-size: 16px;
          text-align: justify;
          display:flex; 
          align-items:center; 
          border-radius:10px; 
          width: 100%;
          justify-content: center;
          padding: 10px;
        }
        
        .user{
          top:0;
        }


        .desc{
          font-size:16px; 
          white-space:pre-wrap;
        font-family: Arial, Helvetica, sans-serif;
      font-weight: 600;}

      .barra-container {
      
      width: 100%;
      background: #ddd;
      height: 10px;
      border-radius: 10px;
      overflow: hidden;
      margin: 10px 0;
    }

    .barra {
      margin-bottom: 20px;
      height: 100%;
      background: #0343d8;
      width: 80%;
      transition: width 1s;
    }

    .nota {
       width: 120px; /* largura fixa para alinhar todas as notas */
  min-width: 30px;     /* largura mínima para o número */
  text-align: left;
  font-weight: bold;
  flex-shrink: 0;
}

.grupoBarra {
  display: flex;
  align-items: center; 
  gap: 10px;           
  margin-bottom: 5px;
  margin-right: 10px;
}

.like, .dislike{
  width: 20px;
    height: 20px;
    border: none;
    cursor: pointer;
    transition: 0.2s;
}

.like{
  background: url('../includes/like.png') no-repeat center/cover;
}

.dislike{
  background: url('../includes/dislike.png') no-repeat center/cover;
}

@media (max-width: 768px){
 
    .desc{
        font-size:40px;
    }
   
  .imag{
    max-width: 100%;
  }
    
    #avaliacoes{
    max-width: 90%;
}
    
    
}

    </style>
  </head>
  
  <body>

  <input type="hidden" id="idjogo" value="<?php echo $_GET['id']; ?>">
    <?php 
    include "../includes/Tela_base.php";
    require_once "../codigo/verificaCadastroJogo.php";

    $cadastro = verificaCadastroJogo($_GET['id']);


    echo "<input type='hidden' id='cadastrado' value='".$cadastro['cadastrado']."'>";

    if($cadastro['cadastrado']){

      require_once "../conexaoApi.php";
      require_once "../codigo/traduzir.php";
      
      $apiKey = "f16d97abd08e4b05aab8a21410287100"; 
      $rawg = new RAWG_API($apiKey);
      $resultado = $rawg->buscarId($_GET['id']);

      $descricaoOriginal = strip_tags($resultado['description']); // remove HTML da descrição
      $descricaoTraduzida = traduzirGratis($descricaoOriginal, 'pt');

      echo '<div class="container">
              <img class="imag" src="'.$resultado['background_image'].'" alt="imagem do jogo">
              <h4>'.$resultado['name'].'</h4>
              <pre class="desc">'.$descricaoTraduzida.'</pre>
            </div>';

    }else{

      echo '<div class="container">
              <img class="imag" src='.$cadastro['img'].' alt="imagem do jogo">
              <h4>'.$cadastro['nomej'].'</h4>
              <pre class="desc">'.$cadastro['descricao'].'</pre>
              <h4>Média: '.round($cadastro['media']).'</h4>
            </div>';


    }
   
    ?>

    <button class="btn btn-primary d-block mx-auto mt-4" id="avaliar" >Avaliar</button>

    
<table>
  
  
    <div id="avaliacoes">
  
    </div>

    <div id="loading">Carregando</div>
    


    <!-- Scripts Bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
  <script>
      $(document).ready(function() {

        $("#avaliar").on('click', function() {
          if(<?php echo json_encode($cadastro['cadastrado']); ?>){

            const descricao = <?php echo json_encode($descricaoTraduzida ?? $cadastro['descricao']); ?>;
            const nomeJogo = <?php echo json_encode($resultado['name'] ?? $cadastro['nomej']); ?>;
            const imagemJogo = <?php echo json_encode($resultado['background_image'] ?? $cadastro['img']); ?>;

            
              $.ajax({
                url: '../codigo/salvarJogo.php',
                type: 'POST',
                data: { idj: <?php echo json_encode($_GET['id']); ?>, nome: nomeJogo, descricao: descricao, img: imagemJogo },
                dataType: 'json',
                success: function(response) {

                    if (response.status) {

                        window.location.href = "frmAva.php?id=" + <?php echo json_encode($_GET['id']); ?>;
                        console.log("Jogo cadastrado com sucesso!");

                    } else {

                        alert('Erro ao atualizar o nome. Tente novamente.');

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
            

          }else{
            window.location.href = "frmAva.php?id=" + <?php echo json_encode($_GET['id']); ?>;
          }

        });

        $(document).on('click', '.like', function() {
            const iddono = $(this).data('iddono');
            const spanLikes = $(this).prev('span'); 
            console.log(iddono);

            $.ajax({
                url: '../codigo/avaliaAva.php',
                type: 'POST',
                data: { idj: <?php echo json_encode($_GET['id']); ?>, iddono: iddono, like: 1},
                dataType: 'json',
                success: function(response) {
                    
                },
                error: function(xhr, status, error) {
                    console.log("Erro na requisição:", xhr.responseText);
                }
            });
        });

        $(document).on('click', '.dislike', function() {
                const iddono = $(this).data('iddono');
                console.log(iddono);

                $.ajax({
                    url: '../codigo/avaliaAva.php',
                    type: 'POST',
                    data: { idj: <?php echo json_encode($_GET['id']); ?>, iddono: iddono, like: 0},
                    dataType: 'json',
                    success: function(response) {
                  
                        
                    },
                    error: function(xhr, status, error) {
                        console.log("Erro na requisição:", xhr.responseText);
                    }
                });
            });



      });//fim document

    const ava = document.getElementById('avaliacoes');
    const loading = document.getElementById('loading');
    let page = 0;
    const idj = document.getElementById('idjogo').value;
    let isLoading = false;

    async function carregarAnalises() {
      
      if (isLoading) return;
      isLoading = true;
      loading.style.display = 'block';

      const offset = page * 10;

      try {
        const resposta = await fetch(`../codigo/pesquisaAnalise.php?offset=${offset}&id=${idj}`);

        const dados = await resposta.json();

        if (dados.analise.length === 0) {
          console.log("Todas as análises carregadas");
          loading.style.display = 'none';
          isLoading = true;
          return; 
        }

        dados.analise.forEach(analise => {
          
          const div = document.createElement('div');

          

          div.className = 'avaliacao';

          const notas = [
                          { titulo: "História", valor: analise.nHistoria },
                          { titulo: "Performance", valor: analise.nPerformance },
                          { titulo: "Jogabilidade", valor: analise.nJogabilidade },
                          { titulo: "Gráficos", valor: analise.nGraficos },
                          { titulo: "Nota Geral", valor: analise.nGeral }
                        ];

          div.innerHTML = `
          
          <input type="hidden" value="${analise.codu}" id="idudono">
          <img src="${analise.img}" alt="user" style="background-color: black;">
          
          <div class="conteudo">
            <p class="user">${analise.nomeu}</p>
            <p id="nota" class="text">${analise.texto}</p>

          ${notas.map(n => `

                  <div class="grupoBarra">
                    <span class="nota">${n.titulo}: </span>
                    <span class="titulo">${n.valor}</span>
                    <div class="barra-container">
                      <div class="barra" style="
                        width: ${n.valor}%;
                        background: ${n.valor >= 70 ? '#00b09b' : (n.valor >= 50 ? '#f0a500' : '#d90429')};"></div>
                    </div>
                    
                  </div>
                  
                `).join('')}
                      

          <div class='grupoBarra'>
          <span>${analise.likes ?? 0}</span>
            <button class="like" data-iddono="${analise.codu}"></button>
            <span>${analise.dislikes ?? 0}</span>
            <button class="dislike" data-iddono="${analise.codu}"></button>
            </div>
          </div>`;

          
          ava.appendChild(div);
    
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

      if (scrollY + alturaJanela >= alturaTotal - 700 && $('#cadastrado').value) {
        carregarAnalises();
      }
    });
  

    // Primeira chamada
    carregarAnalises();



    </script>
</html>
