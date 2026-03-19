
<?php


// /*conectando com o banco de dados (localhost, usuario, senha, nomeBanco)*/

// $conn = mysqli_connect("localhost","root","","aj");
try{
$conn = new PDO("mysql:host=localhost;dbname=gameview", "root", "");

// Configura o modo de erro PDO para lançar exceções
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // echo "Falha na conexão: " . $e->getMessage();
    }


?>