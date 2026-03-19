<?php
// conexao.php - conexão e funções com a API do RAWG.io

class RAWG_API {
    private $api_key;
    private $base_url = "https://api.rawg.io/api/";

    public function __construct($api_key) {
        $this->api_key = $api_key;
    }

    // Requisição GET genérica
    private function get($endpoint, $params = []) {
        $params['key'] = $this->api_key;
        $url = $this->base_url . $endpoint . '?' . http_build_query($params);

        $response = file_get_contents($url);
        if (!$response) {
            return null;
        }
        return json_decode($response, true);
    }

    // Buscar jogo por nome
    public function buscarJogoPorNome($nome) {
        return $this->get("games", ["search" => $nome]);
    }

    // Buscar detalhes de um jogo específico por ID
    public function buscarId($id) {
        return $this->get("games/$id");
    }

    // Listar todos os gêneros disponíveis
    public function listarGeneros() {
        return $this->get("genres");
    }

    // Buscar jogos por gênero (id ou nome)
    public function buscarJogosPorGenero($genero) {
        return $this->get("games", ["genres" => $genero]);
    }

    public function buscarTopAvaliacoes($quantidade = 1) {
    return $this->get("games", [
        "ordering" => "-rating", // ordena por melhor avaliação dos usuários
        "page_size" => $quantidade
    ]);
}
}
?>
