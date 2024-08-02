<?php
session_start();
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        die("Por favor, preencha todos os campos.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user'; // Papel padrão para novos usuários

    $sql = "INSERT INTO usuarios (username, password, email, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $stmt->bind_param("ssss", $username, $hashed_password, $email, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registro bem-sucedido!'); location.href='login.php';</script>";
    } else {
        echo "<script>alert('Falha no registro: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    die("Requisição inválida.");
}
