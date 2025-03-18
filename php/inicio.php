<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redireciona se não estiver logado
    exit();
}

include 'db.php'; // Conexão com o banco

// Capturar filtros da requisição
$tipo = $_GET['tipo'] ?? '';
$data_inicio = $_GET['data_inicio'] ?? '';
$data_fim = $_GET['data_fim'] ?? '';

// Montar a query dinâmica com base nos filtros
$query = "SELECT id, titulo, tipo, data_inicio FROM eventos WHERE 1=1";

if (!empty($tipo)) {
    $query .= " AND tipo = '$tipo'";
}
if (!empty($data_inicio)) {
    $query .= " AND data_inicio >= '$data_inicio'";
}
if (!empty($data_fim)) {
    $query .= " AND data_inicio <= '$data_fim'";
}

$result = mysqli_query($conn, $query);

// Capturar nome do usuário logado
$user_id = $_SESSION['user_id'];
$nome_usuario = $_SESSION['user_nome'] ?? 'Usuário';

// Buscar dados do usuário, incluindo a foto de perfil
$sql_user = "SELECT nome, foto_perfil FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

$foto_perfil = $user['foto_perfil'] ? $user['foto_perfil'] : 'img/default.png'; // Foto padrão se não houver

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <!-- Barra superior -->
        <div class="header">
            <!-- Mural do Usuário -->
            <div class="mural">
                <h2>Bem-vindo, <?= htmlspecialchars($nome_usuario) ?>  
                    <a href="editar_perfil.php" class="perfil-link"><i class="fa-regular fa-circle-user"></i></a>
                </h2>
                <!-- Exibir Foto de Perfil -->
                <div class="user-profile">
                    <img src="<?= $foto_perfil ?>" alt="Foto de Perfil" class="profile-picture">
                </div>

                <form action="logout.php" method="POST">
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i>Sair</button>
                </form>
            </div>
        </div>

        <div class="content">
            <!-- Filtros -->
            <form method="GET" class="filtros">
                <label for="tipo">Tipo:</label>
                <select name="tipo" id="tipo">
                    <option value="">Todos</option>
                    <option value="palestra" <?= $tipo == 'palestra' ? 'selected' : '' ?>>Palestra</option>
                    <option value="oficina" <?= $tipo == 'oficina' ? 'selected' : '' ?>>Oficina</option>
                    <option value="seminario" <?= $tipo == 'seminario' ? 'selected' : '' ?>>Seminário</option>
                    <option value="workshop" <?= $tipo == 'workshop' ? 'selected' : '' ?>>Workshop</option>
                    <option value="novidade" <?= $tipo == 'novidade' ? 'selected' : '' ?>>Novidade</option>
                    <option value="sinistro" <?= $tipo == 'sinistro' ? 'selected' : '' ?>>Sinistro</option>
                </select>

                <label for="data_inicio">Data Início:</label>
                <input type="date" name="data_inicio" value="<?= $data_inicio ?>">

                <label for="data_fim">Data Fim:</label>
                <input type="date" name="data_fim" value="<?= $data_fim ?>">

                <button type="submit">Filtrar</button>
            </form>

            <!-- Tabela de eventos -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Título</th>
                            <th>Data de Início</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($evento = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($evento['tipo']) ?></td>
                                <td><?= htmlspecialchars($evento['titulo']) ?></td>
                                <td><?= htmlspecialchars($evento['data_inicio']) ?></td>
                                <td>
                                    <a href="detalhes_evento.php?id=<?= $evento['id'] ?>" class="detalhes-btn"><i class="fa-solid fa-info"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
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
