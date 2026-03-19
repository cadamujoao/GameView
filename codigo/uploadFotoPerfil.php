<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagem'])) {

    $imagem = $_FILES['imagem'];
    $pasta = '../uploads/';
    $id = $_SESSION['idu'] ?? null;

    if (!$id) {
        die("Erro: usuário não identificado.");
    }

    if (!is_dir($pasta)) mkdir($pasta, 0755, true);

    $permitidas = ['jpg','jpeg','png','gif','webp'];
    $nomeOriginal = $imagem['name'];
    $tmp = $imagem['tmp_name'];
    $erro = $imagem['error'];

    if ($erro === 0) {
        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

        if (!in_array($extensao, $permitidas)) {
            die("Extensão não permitida.");
        }

        // Apaga fotos antigas
        foreach ($permitidas as $ext) {
            $fotoAntiga = $pasta . $id . '.' . $ext;
            if (file_exists($fotoAntiga)) unlink($fotoAntiga);
        }

        $novoNome = $id . '.' . $extensao;
        $caminho = $pasta . $novoNome;

        if (move_uploaded_file($tmp, $caminho)) {
            // Atualiza no banco
            $stmt = $conn->prepare("UPDATE u SET imgu = ? WHERE idu = ?");
            $stmt->execute([$caminho, $id]);

            echo "<script>console.log('Imagem enviada com sucesso!');</script>";
        } else {
            echo "<script>console.log('Erro ao mover a imagem.');</script>";
        }

    } else {
        echo "<script>console.log('Erro no upload (código $erro).');</script>";
        
    }
}
?>

