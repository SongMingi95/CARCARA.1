<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/cadastro_usuario.css">
</head>
<body>
    <div class="container">

    
        <div class="form-box">
            <h2>SEJA BEM VINDO!</h2>
            <img src="img/carcara.png" alt="carcara">

            <form action="cadastro_usuario.php" method="POST">
                <label for="nome">NOME:</label>
                <input type="text" id="nome" name="nome" required>
            
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
            
                <label for="email">EMAIL:</label>
                <input type="email" id="email" name="email" required>
            
                <label for="senha">SENHA:</label>
                <input type="password" id="senha" name="senha" required>
            
                <label for="confirmar">CONFIRME A SENHA:</label>
                <input type="password" id="confirmar" name="confirmar" required>
            
                <button type="submit">CADASTRAR</button>
            </form>
            
            <p class="login-link">Já possui cadastro? <a href="login.php">ENTRAR</a></p>
        </div>
    </div>
</body>
</html>
