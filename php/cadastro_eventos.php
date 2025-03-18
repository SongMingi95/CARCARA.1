<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']) ?? '';
    $descricao = trim($_POST['descricao']) ?? '';
    $tipo = trim($_POST['tipo']) ?? '';
    $data_inicio = $_POST['data_inicio'] ?? '';
    $hora_inicio = $_POST['hora_inicio'] ?? '';
    $hora_fim = $_POST['hora_fim'] ?? '';
    $data_termino = $_POST['data_termino'] ?? NULL;
    $hora_termino_inicio = $_POST['hora_termino_inicio'] ?? NULL;
    $hora_termino_fim = $_POST['hora_termino_fim'] ?? NULL;
    $local = trim($_POST['local']) ?? '';
    $responsavel = trim($_POST['responsavel']) ?? '';

    if (empty($titulo) || empty($descricao) || empty($tipo) || empty($data_inicio) || empty($hora_inicio) || empty($hora_fim) || empty($local) || empty($responsavel)) {
        echo "<script>alert('Todos os campos obrigatórios devem ser preenchidos!'); history.back();</script>";
        exit;
    } else {
        $sql = "INSERT INTO eventos (titulo, descricao, tipo, data_inicio, hora_inicio, hora_fim, data_termino, hora_termino_inicio, hora_termino_fim, local, responsavel)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssss", $titulo, $descricao, $tipo, $data_inicio, $hora_inicio, $hora_fim, $data_termino, $hora_termino_inicio, $hora_termino_fim, $local, $responsavel);

        if ($stmt->execute()) {
            header("Location: sucesso.php");
            exit;
        } else {
            echo "<script>alert('Erro ao cadastrar evento!'); history.back();</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Evento</title>
    <link rel="stylesheet" href="../css/cadastro_evento.css">
    <script src="script.js"></script> 
</head>
<body>
    <div class="container">
        <div class="header"></div>
        
        <div class="content">
            <h1>CADASTRAR EVENTO</h1>
            <form id="formCadastro" method="POST">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required></textarea>

                <label for="tipo">Tipo:</label>
                <select id="tipo" name="tipo" required>
                    <option value="Palestra">Palestra</option>
                    <option value="Seminário">Seminário</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Sinistro">Sinistro</option>
                    <option value="Oficina">Oficina</option>
                    <option value="Novidade">Novidade</option>
                </select>

                <div class="date-time-group">
                    <div>
                        <label for="data-inicio">Data de início:</label>
                        <input type="date" id="data-inicio" name="data_inicio" required>
                    </div>
                    <div>
                        <label for="das1">Dás:</label>
                        <input type="time" id="das1" name="hora_inicio" required>
                    </div>
                    <div>
                        <label for="ate1">Até:</label>
                        <input type="time" id="ate1" name="hora_fim" required>
                    </div>
                </div>

                <div class="date-time-group">
                    <div>
                        <label for="data-termino">Data de término:</label>
                        <input type="date" id="data-termino" name="data_termino">
                    </div>
                    <div>
                        <label for="das2">Dás:</label>
                        <input type="time" id="das2" name="hora_termino_inicio">
                    </div>
                    <div>
                        <label for="ate2">Até:</label>
                        <input type="time" id="ate2" name="hora_termino_fim">
                    </div>
                </div>

                <label for="local">Local:</label>
                <input type="text" id="local" name="local" required>

                <label for="responsavel">Responsável:</label>
                <input type="text" id="responsavel" name="responsavel" required>

                <div class="buttons">
                    <button type="button" class="cancelar-btn" onclick="window.location.href='adm.php'">CANCELAR</button>
                    <button type="submit" class="cadastrar-btn">CADASTRAR</button>
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
