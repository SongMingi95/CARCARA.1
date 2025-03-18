<?php
include 'db.php';

$sql = "SELECT id, titulo, data_inicio, local FROM eventos ORDER BY data_inicio DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Eventos</title>
    <link rel="stylesheet" href="../css/listar_eventos.css">
</head>
<body>
    <div class="container">
        <h1>Eventos Cadastrados</h1>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Data</th>
                    <th>Local</th>
                    <th>Ação</th>
                    <th>Excluir</th> <!-- Nova coluna para o botão de excluir -->
                </tr>
            </thead>
            <tbody>
                <?php while ($evento = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($evento['titulo']) ?></td>
                        <td><?= date('d/m/Y', strtotime($evento['data_inicio'])) ?></td>
                        <td><?= htmlspecialchars($evento['local']) ?></td>
                        <td><a href="editar_eventos.php?id=<?= $evento['id'] ?>" class="editar-btn">Editar</a></td>
                        <td><a href="excluir_evento.php?id=<?= $evento['id'] ?>" class="excluir-btn">Excluir</a></td> 
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button onclick="window.location.href='adm.php'">Voltar ao Painel</button>
    </div>
</body>
</html>
