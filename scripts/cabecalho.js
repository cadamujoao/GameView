$(document).ready(function(){


  // // Se apertar o enter ele chama a função carregarJogos()
  // $('#pesquisa').on('keyup', function(e) {
  //   if (e.key === 'Enter') {
  //     carregarJogos();
  //   }

  // });
  

    
    const gamesContainer = document.getElementById('games');
    const loading = document.getElementById('loading');
    let isLoading = false;
    const apiKey = 'f16d97abd08e4b05aab8a21410287100'; // <-- coloque sua chave aqui

    function pesquisa(){
      carregarJogos();
    }


    

    window.carregarJogos = async function carregarJogos() {

      console.log("aaaaa");
        
      if (isLoading) return;
      isLoading = true;
      loading.style.display = 'block';

      
      try {
        let nome = document.getElementById('pesquisa').value;
        gamesContainer.innerHTML = ''; // Limpa os jogos anteriores

      const div = document.createElement('div');
      div.className = 'game';

        const resposta = await fetch(`https://api.rawg.io/api/games?search="${nome}"&key=${apiKey}`);
        const dados = await resposta.json();

        dados.results.forEach(jogo => {
          const div = document.createElement('div');
          div.className = 'game';

          div.innerHTML =  `<a href="frmJogo.php?id=${jogo.id}" style="text-decoration: none; color: inherit;cursor: default; "> <div class="card">
             ${jogo.background_image ? `<img src="${jogo.background_image}" alt="${jogo.name}" class="img">` : ''}
            <div class="card-body">
                <h5 class="card-title">${jogo.name}</h5>
            </div>
        </div> </a>`;

          gamesContainer.appendChild(div);
        });

        
      } catch (erro) {
        console.error('Erro ao carregar jogos:', erro);
      }

      isLoading = false;
      loading.style.display = 'none';
    }

    $('#pesquisar').on('click', pesquisa);

    const inputElement = document.querySelector('#pesquisa');

    inputElement.addEventListener('keyup', (event) => {
      if (event.key === 'Enter') {
        console.log('Tecla Enter foi pressionada!');
      pesquisa();
      }
    });

  });