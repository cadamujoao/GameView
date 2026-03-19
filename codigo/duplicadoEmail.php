<?php
    include "../conexao.php";

    $email = $_POST['email'];

    $pdo = "SELECT * FROM usuario WHERE emailu = ?";

    $stmt = $conn->prepare($pdo);
    $stmt->execute([$email]);

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