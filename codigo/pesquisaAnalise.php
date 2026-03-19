 <?php   

        include "../conexao.php";
        require "../session_config.php";

        $offset = $_GET['offset'];
        $idj = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM jogo WHERE idJogoApi = ?");
        $stmt->execute([$idj]);
        $jogo = $stmt->fetch();

        if(!$jogo){
            return ['existe' => false];
        }

        $pdo = "SELECT a.codu as codu, a.codj as codj, a.texto as texto, a.nGeral as nGeral, a.nGraficos as nGraficos, a.nJogabilidade as nJogabilidade, a.nPerformance as nPerformance, a.nHistoria as nHistoria, u.nomeu as nomeu, u.imgu as img
                FROM analise a
                JOIN usuario u ON a.codu = u.idu
                WHERE a.codj = ?
                LIMIT 10 OFFSET ?";


        $stmt = $conn->prepare($pdo);

        $stmt->bindValue(1, $jogo['idj'], PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute(); 

        $analise = $stmt->fetchAll();

        foreach ($analise as $key => $a) {
                $stmt = $conn->prepare("
                        SELECT 
                        COUNT(CASE WHEN notaAva = 1 THEN 1 END) AS total_likes,
                        COUNT(CASE WHEN notaAva = 0 THEN 1 END) AS total_dislikes
                        FROM avaliaAnalise
                        WHERE codu_dono = ? AND codj = ?
                ");
                $stmt->execute([$a['codu'], $a['codj']]);
                $avaAna = $stmt->fetch();

                $analise[$key]['likes'] = $avaAna['total_likes'] ?? 0;
                $analise[$key]['dislikes'] = $avaAna['total_dislikes'] ?? 0;
        }
                                


        
        echo json_encode(['existe' => $analise ? true : false, 
                        'analise' => $analise
                        ]);

        $conn = null;
    
?>