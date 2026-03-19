<?php
    include "../conexao.php";

    $token = $_POST['token'];
    $email = $_POST['email'];

    $stmt1 = $conn->prepare("Select * FROM usuario where emailu = ?");
    $stmt1->execute([$email]);
    

    $pdo = "UPDATE usuario SET emailu = ?, token_valida = NULL WHERE token_valida = ?"; 
    
    $stmt = $conn->prepare($pdo);

    try{
        if($stmt1->rowCount() > 0){
            throw new Exception("duplicado");
        }

        $stmt->execute([$email, $token]);

        header('Content-Type: application/json'); 

        echo json_encode(["erro" => false]);
                
    }catch (PDOException $e) {
        echo json_encode(["erro" => true, 
        "mensagem" => "Erro ao redefinir o emial: " . $e->getMessage(),
        "dados" => $e->getMessage()]);
    }

    

    $conn=null;
?>