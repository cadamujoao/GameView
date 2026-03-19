 <?php   
 
    $idj = $_POST['idj'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $img = $_POST['img'];

    include "../conexao.php";
    header('Content-Type: application/json; charset=utf-8');

    $pdo = "INSERT INTO jogo (idJogoApi, nomej, descricao, img) VALUES (?, ?, ?, ?);";

    $stmt = $conn->prepare($pdo);

    

    try{
        $stmt->execute([$idj, $nome, $descricao, $img]); 

        echo json_encode([
            "status" => true,
            "dados" => "Jogo cadastrado com sucesso!"
        ]);

    } 
    catch(Exception $ex) {

        echo json_encode([
                "status" => false,
                "dados" => $ex->getMessage()
        ]);
        
    }

    $conn = null;

?>