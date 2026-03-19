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
        $link = "localhost/gameview/telas/frmAlterarEmail.php?token=".$token;
        $ant = 1.03;
        $dep = 1;

        $texto = '<html>
                    <head>
                        <meta charset="UTF-8">
                        <title>E-mail HTML</title>
                    </head>
                    <body style="font-family: Arial; max-width: 600px; margin: 0 auto; text-align: center; background-color: black;">

                       F
                        <h1 style="color: #007bff; font-size: 50px; margin-bottom: 70px;">Olá! '.$nome.'</h1>

                        <a href="'.$link.'"><button style="background-color: #007bff; border: none; color: white;font-size: 30px; padding:10px; margin-bottom: 50px;" 
                        onmouseover="this.style.scale='.$ant.'"
                        onmouseout="this.style.scale='.$dep.'" >Confirmar cadastro</button></a>

                        <p style="color:white;padding-bottom: 40px">Se o botão não funcionar copie e cole esse link no navegador <a href="'.$link.'">'.$link.'</a></p>
                        
                    </body>
                </html>';
        
        $res = enviarEmailConfirmacao($email, $nome, $texto, "Alterar Email");

       echo json_encode(["erro" => false]);
    }else {
        echo json_encode(["erro" => true]);
    }

    

    $conn=null; // Fechar a conexão com o banco de dados
?>