<?php 

function dadosPerfil($idu){
    include "../conexao.php";

    $pdo = "SELECT u.nomeu, u.emailu, COUNT(a.codu) AS num FROM usuario u LEFT JOIN analise AS a ON u.idu = a.codu WHERE u.idu = ?;";

    $stmt = $conn->prepare($pdo);

    $stmt->execute([$idu]); 
    
    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        return $row;
    } else {
        return null;
    }

    $conn = null;
}

?>