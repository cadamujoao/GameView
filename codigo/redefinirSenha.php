<?php
    include "../conexao.php";

    $token = $_POST['token'];
    $senha = $_POST['senha'];

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Converte a senha para hash

    $pdo = "UPDATE usuario SET senhau = ?, token_valida = NULL WHERE token_valida = ?"; // Atualiza a senha do usuário
    // Vai pesquisar quem tem o token

    $stmt = $conn->prepare($pdo);

    try{
        $stmt->execute([$senhaHash, $token]);

        header('Content-Type: application/json'); // Para retornar o valor em json

        echo json_encode(["erro" => false]);
                
    }catch (PDOException $e) {
        echo json_encode(["erro" => true, "mensagem" => "Erro ao redefinir a senha: " . $e->getMessage()]);
    }

    

    $conn=null; // Fechar a conexão com o banco de dados
?>