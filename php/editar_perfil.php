<?php
session_start();
include("db.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['user_id'];

// Busca os dados do usuário no banco
$sql = "SELECT nome, cpf, email, foto_perfil FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST['nome']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $cpf = preg_replace('/\D/', '', $_POST['cpf']); // Remove caracteres não numéricos
    
    // Upload da foto de perfil
    if (!empty($_FILES['foto']['name'])) {
        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png'];

        if (in_array($extensao, $extensoes_permitidas)) {
            $nome_arquivo = "uploads/perfil_" . $id_usuario . "." . $extensao;
            move_uploaded_file($_FILES['foto']['tmp_name'], $nome_arquivo);
        } else {
            echo "<script>alert('Formato de imagem inválido! Use JPG ou PNG.');</script>";
            $nome_arquivo = $usuario['foto_perfil'];
        }
    } else {
        $nome_arquivo = $usuario['foto_perfil'];
    }

    // Atualiza os dados no banco
    $sql_update = "UPDATE usuarios SET nome = ?, cpf = ?, email = ?, foto_perfil = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $nome, $cpf, $email, $nome_arquivo, $id_usuario);

    if ($stmt_update->execute()) {
        echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href='inicio.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar perfil!');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../css/editar_perfil.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Editar Perfil</h2>
            <form action="editar_perfil.php" method="POST" enctype="multipart/form-data">
                
                <!-- Exibir foto de perfil -->
                <div class="profile-picture">
                    <img src="<?= $usuario['foto_perfil'] ? $usuario['foto_perfil'] : 'img/default.png' ?>" alt="Foto de Perfil">
                </div>

                <label for="foto">Alterar Foto de Perfil:</label>
                <input type="file" name="foto" id="foto" accept="image/png, image/jpeg">

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?= $usuario['cpf'] ?>" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

                <button type="submit">Salvar Alterações</button>
            </form>
            
            <a href="inicio.php">Voltar</a>
        </div>
    </div>
</body>
</html>
