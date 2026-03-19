<?php
    include "../conexao.php";

    $nome = $_POST['nome'];

    $pdo = "SELECT * FROM usuario WHERE nomeu = ?";

    $stmt = $conn->prepare($pdo);
    $stmt->execute([$nome]);

    header('Content-Type: application/json');

    if($stmt->rowCount() > 0) {
        
        echo json_encode([
            "status" => true
        ]);
        
    }else {
        echo json_encode([
            "status" => false
        ]);
    }

    $conn=null;
?>