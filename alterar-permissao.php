<?php
session_start();
include("config.php");

// Verificar se o usuário está logado e se é admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Você deve ser um administrador para acessar esta página.");
}

// Verificar se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];

    // Validação simples
    if (!in_array($new_role, ['user', 'admin'])) {
        die("Função inválida.");
    }

    // Atualizar o nível de acesso no banco de dados
    $sql = "UPDATE usuarios SET role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_role, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Função atualizada com sucesso!'); location.href='index.php?page=gerenciar';</script>";
    } else {
        echo "<script>alert('Falha ao atualizar a função: " . $stmt->error . "'); location.href='index.php?page=gerenciar';</script>";
    }

    $stmt->close();
} else {
    die("Requisição inválida.");
}

$conn->close();
?>
