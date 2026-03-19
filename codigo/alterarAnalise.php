<?php 
    header('Content-Type: application/json');
    require_once "../session_config.php";
    include "../conexao.php";

    $idjogo = $_POST['idjogo'] ?? 23598;
    $notaH = $_POST['nH'] ?? 50;
    $notaG = $_POST['nG']?? 50;  
    $notaP = $_POST['nP']?? 50;
    $notaJ = $_POST['nJ']?? 50;
    $texto = $_POST['texto'] ?? "dsdsdsdsdsdsd";

    $stmt = $conn->prepare("SELECT idj, soma, contador FROM jogo WHERE idJogoApi = ?");
    $stmt->execute([$idjogo]);
    $row = $stmt->fetch();

    $notaGeral = ($notaH + $notaG + $notaP + $notaJ) / 4;

    $id = $row['idj'];
    $soma = $row['soma'];
    $contador = $row['contador'];

   $stmt = $conn->prepare("SELECT nGeral FROM analise WHERE codu=? AND codj=?");
    $stmt->execute([$_SESSION['idu'], $id]);
    $ana = $stmt->fetch();

$nGeralA = $ana['nGeral'];


    $stmt = $conn->prepare("UPDATE analise SET texto = ?, nGeral = ?, nHistoria = ?, nGraficos = ?, nJogabilidade = ?, nPerformance = ? WHERE codu=? and codj=?");

    try{

        $stmt->execute([$texto, $notaGeral, $notaH, $notaG, $notaJ, $notaP,$_SESSION['idu'],$id]);

        $somaMenos = $soma - $nGeralA;
        $somaNova = $somaMenos + $notaGeral;
        $media = $somaNova / $contador;

        $stmt = $conn->prepare("UPDATE jogo SET soma =?, media = ? WHERE idj= ?");
        $stmt->execute([$somaNova, $media, $id]);

        echo json_encode(["erro" => false]);

    }
    catch (PDOException $e) {

        echo json_encode(["erro" => true, "mensagem" => "Erro ao inserir análise: " . $e->getMessage()]);
        
    }

    $conn = null;

?>