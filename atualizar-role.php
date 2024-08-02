<?php
session_start();
include("config.php");

// Verificar se o usuário está logado e se é um administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Acesso negado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $role = $_POST['role'];

    // Validar o papel
    if (!in_array($role, ['user', 'admin'])) {
        die("Papel inválido.");
    }

    $sql = "UPDATE usuarios SET role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $stmt->bind_param("si", $role, $id);

    if ($stmt->execute()) {
        header("Location: gerenciar-usuarios.php");
        exit();
    } else {
        die("Erro ao atualizar papel: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
