<?php
session_start();
include("config.php");

// Verifique se o usuário está autenticado e é um administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<p>Acesso negado. Você precisa ser um administrador para acessar esta página.</p>";
    exit();
}

// Verificar a ação a ser executada
$acao = $_REQUEST['acao'] ?? '';
$id = $_REQUEST['id'] ?? null;
$placa = $_POST['placa'] ?? '';
$proprietario = $_POST['proprietario'] ?? '';
$modelo = $_POST['modelo'] ?? '';
$cor = $_POST['cor'] ?? '';
$horario_entrada = $_POST['horario_entrada'] ?? '';
$horario_saida = $_POST['horario_saida'] ?? '';

if ($acao === 'cadastrar') {
    // Inserir novo veículo
    $sql = "INSERT INTO veiculo (placa, proprietario, modelo, cor, horario_entrada, horario_saida) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $placa, $proprietario, $modelo, $cor, $horario_entrada, $horario_saida);
    
    if ($stmt->execute()) {
        echo "<script>alert('Veículo cadastrado com sucesso!'); location.href='index.php?page=listar';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar veículo: " . $stmt->error . "'); location.href='index.php?page=novo';</script>";
    }

    $stmt->close();
} elseif ($acao === 'editar') {
    // Atualizar veículo existente
    if ($id === null) {
        die("ID do veículo não fornecido.");
    }

    $sql = "UPDATE veiculo SET placa=?, proprietario=?, modelo=?, cor=?, horario_entrada=?, horario_saida=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $placa, $proprietario, $modelo, $cor, $horario_entrada, $horario_saida, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Veículo atualizado com sucesso!'); location.href='index.php?page=listar';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar veículo: " . $stmt->error . "'); location.href='index.php?page=editar&id=$id';</script>";
    }

    $stmt->close();
} elseif ($acao === 'excluir') {
    // Excluir veículo existente
    if ($id === null) {
        die("ID do veículo não fornecido.");
    }

    $sql = "DELETE FROM veiculo WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Veículo excluído com sucesso!'); location.href='index.php?page=listar';</script>";
    } else {
        echo "<script>alert('Erro ao excluir veículo: " . $stmt->error . "'); location.href='index.php?page=listar';</script>";
    }

    $stmt->close();
} else {
    echo "<p>Ação inválida.</p>";
}

$conn->close();
?>
