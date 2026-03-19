<?php 
    header('Content-Type: application/json');
    require_once "../session_config.php";
    include "../conexao.php";
    

    $nome = $_POST['nome'];
    $stmt = $conn->prepare("UPDATE usuario SET nomeu = ? WHERE idu = ?");

    try {

        $stmt->execute([$nome, $_SESSION['idu']]);

        
        echo json_encode([

            "status" => true,
            "dados" => "Nome atualizado"

        ]);



    } catch(Exception $ex) {

        if ($ex->getCode() == 23000) {

            echo json_encode(["status" => false, "dados" => "duplicado"]);

        } else {

            echo json_encode(["status" => false, "dados" => $e->getMessage()]);

        }

        
    }

    $conn = null;

?>