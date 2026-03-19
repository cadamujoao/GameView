<?php
    require_once "../session_config.php"; 
    include "../conexao.php";

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $pdo = "SELECT idu, nomeu, senhau FROM usuario WHERE emailu = ? and validado = 1";
    // Vai pesquisar só quem é validado, mas pode mudar

    $stmt = $conn->prepare($pdo);
    $stmt->execute([$email]); 

    header('Content-Type: application/json'); // Para retornar o valor em json

    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch();

        if (password_verify($senha, $row['senhau'])){ // Verifica a senha hash com a senha digitada agora

            $_SESSION['idu'] = $row['idu'];
            $_SESSION['nome'] = $row['nomeu'];

            echo json_encode([
                "erro" => false
                ]);
            

        }else{
            echo json_encode(["erro" => true]);
        }
    }else {
        echo json_encode(["erro" => true]);
    }

    

    $conn=null; // Fechar a conexão com o banco de dados
?>