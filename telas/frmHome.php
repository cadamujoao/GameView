  <?php
  
  require_once "../session_config.php"; 

  include "../includes/Tela_base.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../scripts/cabecalho.js"></script>

    

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/cards.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<style>
  
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
  
    <div id="games">
        
    </div>
    <div id="loading">Carregando</div>
    <div id="fim">Acabaram as avaliações.</div>
    <script>
    
    const gamesContainer = document.getElementById('games');
    const loading = document.getElementById('loading');
    const fim = document.getElementById('fim');
    let page = 0;
    let isLoading = false;

  

    async function acarregarJogos() {
      
      if (isLoading) return;
      isLoading = true;
      loading.style.display = 'block';
      fim.style.display = 'none';

      const offset = page * 10;

      try {
        const resposta = await fetch(`../codigo/carregarJogos.php?offset=${offset}`);

        const dados = await resposta.json();

        if (dados.resultado.length === 0) {
          console.log("Todas as análises carregadas");
          loading.style.display = 'none';
          fim.style.display = 'block';
          isLoading = true;
          return; 
        }

        dados.resultado.forEach(jogo => {
          
          const div = document.createElement('div');

          div.className = 'game';

          let nota = Math.round(jogo.media);
          let corNota = '';
          let classe = '';

          if(jogo.media < 100) {

            corNota = jogo.media == 90 ? '#1c8200ff' :
                            jogo.media >= 70 ? '#bdcb00ff' :
                            jogo.media >= 50 ? '#c06300ff' :
                            '#990000';
                            
          }else{
            classe = "gold";
            
          }

          div.className = 'game';

          div.innerHTML =  `<a href="frmJogo.php?id=${jogo.idJogoApi}" style="text-decoration: none;color: inherit;cursor: default; "> 
                                <div class="card">
                <img class="img" src="${jogo.img}"  loading="lazy" alt="${jogo.nomej}" >
                                  <div class="card-body">
                                      <h5 class="card-title" >${jogo.nomej}</h5>
                                    <h3 id="nota" class="${classe}" style="display:flex; align-items:center; border-radius:10px;background-color:${corNota}; max-width: 30%;justify-content: center;aspect-ratio: 1;">${nota}</h3>
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

      if (scrollY + alturaJanela >= alturaTotal - 700 && document.getElementById('pesquisa').value.trim() === "") {
        acarregarJogos();
      }
    });
  

    // Primeira chamada
    acarregarJogos();

  </script>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>