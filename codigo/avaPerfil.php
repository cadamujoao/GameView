<?php 
header('Content-Type: text/html; charset=utf-8');
require_once "../conexao.php";
require_once "../session_config.php";

    $offset = $_GET['offset'];

    $pdo = "SELECT idJogoApi, nomej, img, nGeral FROM jogo inner JOIN analise AS a ON jogo.idj = a.codj WHERE a.codu = ? LIMIT 10 OFFSET ?;";

    $stmt = $conn->prepare($pdo);

    $stmt->bindValue(1, $_SESSION['idu'], PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);

    $stmt->execute();

    try {

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([ "resultado" => $res]);

    }
    catch (PDOException $e) {

        echo json_encode([ "resultado" => [], "erro" => true, "mensagem" => $e->getMessage() ]);

    }   



?>