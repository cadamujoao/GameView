  <?php
  require_once "session_config.php"; 

  if(!isset($_SESSION['idu'])) {
      header("Location: usuario/frmLogin.php");
      exit();
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<style>

    
   



     #loading {
      text-align: center;
      padding: 20px;
      font-weight: bold;
    }

</style>
<body>
    <div id="games">
        
       

    </div>
    <div id="loading">Carregando</div>

    <script>
    const gamesContainer = document.getElementById('games');
    const loading = document.getElementById('loading');
    let page = Math.floor((Math.random() * 1000) + 1);
    let isLoading = false;
    const apiKey = '4b6686a6b8fc490aa5ad5b39be7f7981'; // <-- coloque sua chave aqui

    async function carregarJogos() {
      if (isLoading) return;
      isLoading = true;
      loading.style.display = 'block';

      try {
        const resposta = await fetch(`https://api.rawg.io/api/games?page=${page}&page_size=15&key=${apiKey}`);
        const dados = await resposta.json();

        dados.results.forEach(jogo => {
          const div = document.createElement('div');
          div.className = 'game';

          div.innerHTML =  `<a href="jogos/frmJogo.php?id=${jogo.id}"> <div class="card">
             ${jogo.background_image ? `<img src="${jogo.background_image}" alt="${jogo.name}">` : ''}
            <div class="card-body">
                <h5 class="card-title">${jogo.name}</h5>
                <p class="card-text">${jogo.rating} sdsdsdsd ${jogo.released} </p>
            </div>
        </div> </a>`;

        

          

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

      if (scrollY + alturaJanela >= alturaTotal - 100) {
        carregarJogos();
      }
    });

    // Primeira chamada
    carregarJogos();
  </script>
</body>
</html>