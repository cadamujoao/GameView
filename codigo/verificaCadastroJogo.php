 <?php   
 
    function verificaCadastroJogo($idj){
        include "../conexao.php";

        $pdo = "SELECT * FROM jogo WHERE idJogoApi = ?;";

        $stmt = $conn->prepare($pdo);

        $stmt->execute([$idj]); 

        
        
        if($stmt->rowCount() > 0) {

            $row = $stmt->fetch();
            $row['cadastrado'] = false;
            
            
        } else {
            $row['cadastrado'] = true;
        }

        return $row;

        $conn = null;
    }

    

?>