<?php
include("init.php"); // Certifique-se de que a sessão está iniciada
include("config.php");

// Verifique se o usuário está autenticado e é um administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<p>Acesso negado. Você precisa ser um administrador para acessar esta página.</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $role = $_POST['role'];

    if ($role !== 'user' && $role !== 'admin') {
        die("Função inválida.");
    }

    $sql = "UPDATE usuarios SET role=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $role, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Função do usuário atualizada com sucesso!'); location.href='gerenciar-usuarios.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar a função do usuário: " . $stmt->error . "'); location.href='gerenciar-usuarios.php';</script>";
    }

    $stmt->close();
} else {
    die("Requisição inválida.");
}

$conn->close();
?>
