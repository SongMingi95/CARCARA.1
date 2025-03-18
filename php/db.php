<?php
$servidor = "localhost:3306";
$usuario = "root";  // Altere se necessário
$senha = "";  // Altere se necessário
$banco = "carcara";

// Criando a conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
