<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf_email = $_POST['cpf-email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, cpf, email, senha, tipo FROM usuarios WHERE cpf = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $cpf_email, $cpf_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome, $cpf, $email, $hashed_password, $tipo);
        $stmt->fetch();

        if (password_verify($senha, $hashed_password)) {
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['user_nome'] = $nome;
            $_SESSION['user_tipo'] = $tipo;

            if ($tipo == 'admin') {
                header("Location: adm.php"); // Redireciona para a página do ADM
            } else {
                header("Location: inicio.php"); // Redireciona para a página inicial do usuário comum
            }
            exit();
        } else {
            $error_message = "Credenciais inválidas! Tente novamente.";
        }
    } else {
        $error_message = "Usuário não encontrado! Tente novamente.";
    }

    $stmt->close();
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container">
       
        <div class="header">
            
        </div>

        
        <div class="content">
            <h1>SEJA BEM VINDO!</h1>
            <form id="loginForm" method="POST" action="">
                <label for="cpf-email">CPF / EMAIL:</label>
                <input type="text" id="cpf-email" name="cpf-email" placeholder="Digite seu CPF ou Email" required>

                <label for="senha">SENHA:</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

                <button type="submit" class="login-btn">ENTRAR</button>
            </form>

            <p class="login-link">Não possui cadastro? <a href="index.php">Cadastre-se</a></p>
            
            <?php

            if (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
            ?>
        </div>

        <footer>
            
            <div class="logo">
                <span>CARCARÁ</span>
                <p>O Pássaro da notícia</p>
            </div>
        </footer>
    </div>
</body>
</html>
