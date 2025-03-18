<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: LOGIN.php");
    exit();
}

include 'db.php'; // Arquivo de conexão com o banco

// Verifica se o ID foi passado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Evento não encontrado.";
    exit();
}

$id = $_GET['id'];

// Buscar os detalhes do evento no banco de dados
$query = "SELECT * FROM eventos WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$evento = mysqli_fetch_assoc($result);

if (!$evento) {
    echo "Evento não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento</title>
    <link rel="stylesheet" href="../css/detalhes_evento.css">
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($evento['titulo']) ?></h1>
        <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($evento['descricao'])) ?></p>
        <p><strong>Tipo:</strong> <?= htmlspecialchars($evento['tipo']) ?></p>

        <div class="date-time-group">
            <div>
                <p><strong>Data de Início:</strong> <?= htmlspecialchars($evento['data_inicio']) ?></p>
            </div>
            <div>
                <p><strong>Hora de Início:</strong> <?= htmlspecialchars($evento['hora_inicio']) ?></p>
            </div>
            <div>
                <p><strong>Hora de Término:</strong> <?= htmlspecialchars($evento['hora_fim']) ?></p>
            </div>
        </div>

        <?php if (!empty($evento['data_termino'])): ?>
            <div class="date-time-group">
                <div>
                    <p><strong>Data de Término:</strong> <?= htmlspecialchars($evento['data_termino']) ?></p>
                </div>
                <div>
                    <p><strong>Hora de Término:</strong> <?= htmlspecialchars($evento['hora_termino_inicio']) ?></p>
                </div>
                <div>
                    <p><strong>Hora de Término:</strong> <?= htmlspecialchars($evento['hora_termino_fim']) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <p><strong>Local:</strong> <?= htmlspecialchars($evento['local']) ?></p>
        <p><strong>Responsável:</strong> <?= htmlspecialchars($evento['responsavel']) ?></p>

        <a href="inicio.php" class="btn-voltar">Voltar</a>
    </div>
</body>
</html>
