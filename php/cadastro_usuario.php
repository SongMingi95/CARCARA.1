<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = 'padrao'; // Define sempre como usuário padrão

    $sql_verifica = "SELECT id FROM usuarios WHERE cpf = ? OR email = ?";
    $stmt_verifica = $conn->prepare($sql_verifica);
    $stmt_verifica->bind_param("ss", $cpf, $email);
    $stmt_verifica->execute();
    $stmt_verifica->store_result();

    if ($stmt_verifica->num_rows > 0) {
        echo "<script>alert('Erro: CPF ou E-mail já cadastrado!'); window.location.href='cadastro.php';</script>";
        exit();
    }

    $stmt_verifica->close();

    $sql = "INSERT INTO usuarios (nome, cpf, email, senha, tipo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $nome, $cpf, $email, $senha, $tipo);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro na preparação da consulta.";
    }

    $conn->close();
}
?>
