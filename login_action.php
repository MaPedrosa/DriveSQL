<?php
session_start();
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password, role FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password, $role);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role; // Armazena o papel do usuário
            echo "<script>alert('Login bem-sucedido!'); location.href='index.php';</script>";
        } else {
            echo "<script>alert('Senha inválida.'); location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado.'); location.href='login.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    die("Requisição inválida.");
}
