<?php
include 'db.php';

// Recupera todos os eventos cadastrados
$sql = "SELECT id, titulo, tipo, data_inicio, local FROM eventos ORDER BY data_inicio DESC";
$result = $conn->query($sql);

// Verifica se a consulta retornou eventos
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}

// Organiza os eventos por tipo
$eventos_por_tipo = [];
while ($evento = $result->fetch_assoc()) {
    $eventos_por_tipo[$evento['tipo']][] = $evento;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Eventos</title>
    <link rel="stylesheet" href="../css/listar_eventos.css">
</head>
<body>
    <div class="container">
        <h1>Eventos Cadastrados</h1>

        <?php
        // Verifica se há eventos e exibe por tipo
        if (empty($eventos_por_tipo)) {
            echo "<p>Não há eventos cadastrados no momento.</p>";
        } else {
            // Exibe eventos agrupados por tipo
            foreach ($eventos_por_tipo as $tipo => $eventos) {
                echo "<h2>$tipo</h2>";
                echo "<table>";
                echo "<thead><tr><th>Título</th><th>Data</th><th>Local</th></tr></thead><tbody>";

                foreach ($eventos as $evento) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($evento['titulo']) . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($evento['data_inicio'])) . "</td>";
                    echo "<td>" . htmlspecialchars($evento['local']) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            }
        }
        ?>

        <button onclick="window.location.href='adm.php'">Voltar ao Painel</button>
    </div>
</body>
</html>
