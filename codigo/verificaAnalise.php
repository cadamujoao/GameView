 <?php   
 
    function verificaAnalise($idj,$idu){
        include "../conexao.php";

        $stmt = $conn->prepare("SELECT * FROM jogo WHERE idJogoApi = ?");
        $stmt->execute([$idj]);
        $jogo = $stmt->fetch();

        if(!$jogo){
            return ['existe' => false];
        }

        $pdo = "SELECT * FROM analise WHERE codj = ? and codu = ?;";

        $stmt = $conn->prepare($pdo);

        $stmt->execute([$jogo['idj'], $idu]); 

        $analise = $stmt->fetch();
        
        return ['existe' => $analise ? true : false, 
                'jogo' => $jogo, 
                'analise' => $analise];

        $conn = null;
    }

    

?>