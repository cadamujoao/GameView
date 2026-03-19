<?php
    include "../conexao.php";

    require_once "../enviarEmail.php"; // funçõa para enviar emails

    $email = $_POST['email'];

    $pdo = "SELECT idu, nomeu, senhau FROM usuario WHERE emailu = ? and validado = 1";
    // Vai pesquisar só quem é validado, mas pode mudar

    $stmt = $conn->prepare($pdo);
    $stmt->execute([$email]); 

    header('Content-Type: application/json'); // Para retornar o valor em json

    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch();

        $token = bin2hex(random_bytes(16)); // token para inves de id ou email

        $pdo2 = "UPDATE usuario SET token_valida = ? WHERE emailu = ?"; 

        $stmt2 = $conn->prepare($pdo2);
        $stmt2->execute([$token, $email]); 
        // Adiciona o token para identificar o usuário que vai trocar a senha

        $nome = $row['nomeu'];
        $texto = "Olá $nome!<br> <a href='localhost/gameview/usuario/frmRedefinirSenha.php?token=$token'>Clique no link para redefinir sua senha</a>";
        
        $res = enviarEmailConfirmacao($email, $nome, $texto, "Redefinição de senha");

       echo json_encode(["erro" => false]);
    }else {
        echo json_encode(["erro" => true]);
    }

    

    $conn=null; // Fechar a conexão com o banco de dados
?>