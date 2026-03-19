<?php 
    header('Content-Type: application/json');
    require_once "../session_config.php";
    include "../conexao.php";

    $idjogo = $_POST['idjogo'];
    $notaH = $_POST['nH'];
    $notaG = $_POST['nG'];  
    $notaP = $_POST['nP'];
    $notaJ = $_POST['nJ'];
    $texto = $_POST['texto'];

    $stmt = $conn->prepare("SELECT idj, soma, contador FROM jogo WHERE idJogoApi = ?");
    $stmt->execute([$idjogo]);
    $row = $stmt->fetch();


    $notaGeral = ($notaH + $notaG + $notaP + $notaJ) / 4;

    $id = $row['idj'];
    $soma = $row['soma'];
    $contador = $row['contador'];

    $stmt = $conn->prepare("INSERT INTO analise (codu, codj, texto, nGeral, nHistoria, nGraficos, nJogabilidade, nPerformance) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    try{

        $stmt->execute([$_SESSION['idu'],$id, $texto, $notaGeral, $notaH, $notaG, $notaJ, $notaP]);

        $stmt = $conn->prepare("UPDATE jogo set soma = ?, contador = ?, media = ? WHERE idj = ?");
        $stmt->execute([$notaGeral + $soma, $contador + 1, ($notaGeral + $soma) / ($contador + 1), $id]);
       
        echo json_encode(["erro" => false]);

    }
    catch (PDOException $e) {

        echo json_encode(["erro" => true, "mensagem" => "Erro ao inserir análise: " . $e->getMessage()]);
        
    }

    $conn = null;

?>