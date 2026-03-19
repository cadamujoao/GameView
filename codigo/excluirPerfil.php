<?php 
    header('Content-Type: application/json');
    require_once "../session_config.php";
    include "../conexao.php";

    $idu = $_POST['id'];

    $stmt = $conn->prepare("UPDATE usuario set validado = 0, imgu = '../includes/user.png' WHERE idu = ?");

    try {

        $stmt->execute([$idu]);

        unset($_SESSION['idu']);
        
        echo json_encode([

            "status" => true,
            "dados" => "Perfil deletado"

        ]);



    } catch(Exception $ex) {
            echo json_encode(["status" => false, "dados" => $e->getMessage()]);


        
    }

    $conn = null;

?>