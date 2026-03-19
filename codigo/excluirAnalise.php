<?php 
    header('Content-Type: application/json');
    require_once "../session_config.php";
    include "../conexao.php";

    $idjogo = $_POST['idjogo'];

    $stmt = $conn->prepare("SELECT idj, soma, contador FROM jogo WHERE idJogoApi = ?");
    $stmt->execute([$idjogo]);
    $row = $stmt->fetch();


    $id = $row['idj'];
 
    $stmt = $conn->prepare("DELETE FROM analise WHERE codu=? and codj=?");
    try{

        $stmt->execute([$_SESSION['idu'],$id]);

        echo json_encode(["erro" => false]);

    }
    catch (PDOException $e) {

        echo json_encode(["erro" => true, "mensagem" => "Erro ao inserir análise: " . $e->getMessage()]);
        
    }

    $conn = null;

?>