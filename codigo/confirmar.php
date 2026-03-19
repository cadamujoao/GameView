<?php
include "../conexao.php";

if (isset($_GET['token'])) { // Verifica se tem token, pelo link do site (?token=)
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE token_valida = ?"); // Busca o usuário que tem o token
    $stmt->execute([$token]);

    if ($stmt->rowCount() > 0) {

        // Define o validado com "true" e apaga o token de validação do usuário
        $stmtUpdate = $conn->prepare("UPDATE usuario SET validado = 1, token_valida = NULL WHERE token_valida = ?");
        $stmtUpdate->execute([$token]);

        echo "E-mail confirmado com sucesso!";

    } else {
        echo "Token inválido ou expirado.";
    }

} else {
    echo "Token ausente.";
}

$conn = null;
?>
