<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os dados do evento
    $sql = "SELECT * FROM eventos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $evento = $resultado->fetch_assoc();

    if (!$evento) {
        die("Evento não encontrado!");
    }
} else {
    die("ID do evento não especificado!");
}

// Processamento do formulário de edição
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $data_inicio = $_POST['data_inicio'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];
    $data_termino = $_POST['data_termino'] ?? NULL;
    $hora_termino_inicio = $_POST['hora_termino_inicio'] ?? NULL;
    $hora_termino_fim = $_POST['hora_termino_fim'] ?? NULL;
    $local = $_POST['local'];
    $responsavel = $_POST['responsavel'];

    $sql = "UPDATE eventos SET titulo=?, descricao=?, tipo=?, data_inicio=?, hora_inicio=?, hora_fim=?, data_termino=?, hora_termino_inicio=?, hora_termino_fim=?, local=?, responsavel=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $titulo, $descricao, $tipo, $data_inicio, $hora_inicio, $hora_fim, $data_termino, $hora_termino_inicio, $hora_termino_fim, $local, $responsavel, $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Evento editado com sucesso!');
                window.location.href = 'listar_eventos.php';
              </script>";
        exit();
    } else {
        echo "Erro ao editar evento: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="../css/editar_evento.css">
</head>
<body>
    <div class="container">
    <div class="header">
           
        </div>
        <div class="content">
        <h1>EDITAR EVENTO</h1>
        <p>(Selecione o campo que deseja editar)</p>
        <form method="POST">
            <label for="titulo">Título :</label>
            <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($evento['titulo']) ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?= htmlspecialchars($evento['descricao']) ?></textarea>

            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="Palestra" <?= $evento['tipo'] == 'Palestra' ? 'selected' : '' ?>>Palestra</option>
                <option value="Seminário" <?= $evento['tipo'] == 'Seminário' ? 'selected' : '' ?>>Seminário</option>
                <option value="Workshop" <?= $evento['tipo'] == 'Workshop' ? 'selected' : '' ?>>Workshop</option>
                <option value="Novidade" <?= $evento['tipo'] == 'Novidade' ? 'selected' : '' ?>>Novidade</option>
                <option value="Sinistro" <?= $evento['tipo'] == 'Sinistro' ? 'selected' : '' ?>>Sinistro</option>
                <option value="Oficina" <?= $evento['tipo'] == 'Oficina' ? 'selected' : '' ?>>Oficina</option>
            </select>

            <label for="data-inicio">Data de início:</label>
            <input type="date" id="data-inicio" name="data_inicio" value="<?= $evento['data_inicio'] ?>" required>

            <label for="das1">Das:</label>
            <input type="time" id="das1" name="hora_inicio" value="<?= $evento['hora_inicio'] ?>" required>

            <label for="ate1">Até:</label>
            <input type="time" id="ate1" name="hora_fim" value="<?= $evento['hora_fim'] ?>" required>

            <label for="data-termino">Data de término:</label>
            <input type="date" id="data-termino" name="data_termino" value="<?= $evento['data_termino'] ?>">

            <label for="das2">Das:</label>
            <input type="time" id="das2" name="hora_termino_inicio" value="<?= $evento['hora_termino_inicio'] ?>">

            <label for="ate2">Até:</label>
            <input type="time" id="ate2" name="hora_termino_fim" value="<?= $evento['hora_termino_fim'] ?>">

            <label for="local">Local:</label>
            <input type="text" id="local" name="local" value="<?= htmlspecialchars($evento['local']) ?>" required>

            <label for="responsavel">Responsável:</label>
            <input type="text" id="responsavel" name="responsavel" value="<?= htmlspecialchars($evento['responsavel']) ?>" required>

            <div class="buttons">
                <button type="button" onclick="window.location.href='listar_eventos.php'" class="cancelar-btn">CANCELAR</button>
                <button type="submit" class="finalizar-btn">SALVAR ALTERAÇÕES</button>
            </div>
        </form>
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
</body>
</html>
