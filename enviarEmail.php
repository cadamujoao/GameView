<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php'; // Garante que o autoload só será carregado uma vez

function enviarEmailConfirmacao($email, $nome, $texto, $assunto) {
    try {
        $dominio = substr(strrchr($email, "@"), 1);

        if (!checkdnsrr($dominio, "MX")) {
            throw new Exception("Domínio de e-mail inválido");
        }

        
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cadamujoao@gmail.com';
        $mail->Password   = 'nkwclavwbwxzckip'; // Senha de app
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('cadamujoao@gmail.com', 'João');
        $mail->addAddress($email, $nome);

        $mail->isHTML(true);
        $mail->Subject = $assunto;;
        $mail->Body    = $texto;
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->send();

        return [ "sucesso" => true ];

    } catch (Exception $e) {
        
        return [
            "sucesso" => false,
            "erro" => $e->getMessage()
        ];
    }
}
