<?php
include 'db.php';

// Verifica se o ID foi passado pela URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara e executa a consulta para excluir o evento
    $sql = "DELETE FROM eventos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // "i" para integer (ID)
    
    if ($stmt->execute()) {
        // Redireciona de volta para a página de lista de eventos após a exclusão
        header("Location: listar_eventos.php");
        exit();
    } else {
        echo "Erro ao excluir o evento!";
    }
}
?>
