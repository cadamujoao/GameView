<?php

    require_once "../enviarEmail.php";
    include "../conexao.php";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("INSERT INTO usuario (nomeu, emailu, senhau, token_valida) 
    values (?, ?, ?, ?)");

    // Try do cadastro
    try{

        $conn->beginTransaction(); // Começa um "rascunho" do cadastro

        $token = bin2hex(random_bytes(16)); // Cria um código único para fazer a verificação do email do usuário
        $link = "localhost/gameview/codigo/confirmar.php?token=$token"; // Link de redirecionamento para confirmar o email

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Converte a senha para hash
        
        $stmt->execute([$nome,$email, $senhaHash, $token]);
        
        $ant = '1.01';
        $dep = '1';

        $texto= '<html>
                    <head>
                        <meta charset="UTF-8">
                        <title>E-mail HTML</title>
                    </head>
                    <body style="font-family: Arial; max-width: 600px; margin: 0 auto; text-align: center; background-color: black;">

                        
                        <h1 style="color: #007bff; font-size: 50px; margin-bottom: 70px;">Olá! '.$nome.'</h1>

                        <a href="'.$link.'"><button style="background-color: #007bff; border: none; color: white;font-size: 30px; padding:10px; margin-bottom: 50px;" 
                        onmouseover="this.style.scale='.$ant.'"
                        onmouseout="this.style.scale='.$dep.'" >Confirmar cadastro</button></a>

                        <p style="color:white;padding-bottom: 40px">Se o botão não funcionar copie e cole esse link no navegador <a href="'.$link.'">'.$link.'</a></p>
                        
                    </body>
                </html>';

        $res = enviarEmailConfirmacao($email, $nome, $texto, "Confirmação de Cadastro");
       
        if(!$res['sucesso']) {
            throw new Exception("Erro ao enviar o e-mail: ". $res['erro']);
        }


        echo json_encode([
            "status" => "ok",
            "dados" => "Cadastro realizado com sucesso!"
        ]);


        $conn->commit(); // Envia o "rascunho" do cadastro

    } catch(Exception $ex) {

        $conn->rollBack(); // Apaga o "rascunho"

        echo json_encode([
                "status" => "erro",
                "dados" => $ex->getMessage()
        ]);
        
    }// Fim try catch do insert

    $conn=null;
?>