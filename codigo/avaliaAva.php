<?php 
    header('Content-Type: application/json');
    require_once "../session_config.php";
    include "../conexao.php";

    $id = $_POST['idj'];
    $idu = $_POST['iddono'];
    $like = $_POST['like'];

    $stmt1 = $conn->prepare("SELECT * FROM jogo WHERE idJogoApi = ?");
    $stmt1->execute([$id]);
    $jogo = $stmt1->fetch();

    try{
        $stmt3 = $conn->prepare("SELECT * FROM avaliaanalise WHERE codu_avaliador =? and codu_dono = ? and codj = ?;");
        $stmt3->execute([$_SESSION['idu'],$idu,$jogo['idj']]);
        $existeLike = $stmt3->fetch();

            if($existeLike){
                if($existeLike['notaAva'] == $like){
                    $stmt2 = $conn->prepare("DELETE FROM avaliaanalise WHERE codu_avaliador =? and codu_dono = ? and codj = ?;");
                    $stmt2->execute([$_SESSION['idu'],$idu,$jogo['idj']]);
                }else{
                    $stmt4 = $conn->prepare("UPDATE avaliaanalise SET notaAva = ? WHERE codu_avaliador = ? AND codu_dono = ? AND codj = ?");
                    $stmt4->execute([$like, $_SESSION['idu'], $idu,$jogo['idj']]);
                }

            }else{
                
                $stmt5 = $conn->prepare("INSERT INTo avaliaanalise (codu_avaliador, codu_dono, codj, notaAva) values (?, ?, ?, ?);");
                $stmt5->execute([$_SESSION['idu'],$idu,$jogo['idj'],$like]);
                    
            }
            echo json_encode(["erro" => false]);
        

    }
    catch (PDOException $e) {

        echo json_encode(["erro" => true, "mensagem" => "Erro ao inserir análise: " . $e->getMessage()]);
        
    }

    $conn = null;

?>