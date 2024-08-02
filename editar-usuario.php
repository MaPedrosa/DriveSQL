<?php
include("init.php"); // Ajuste o caminho se necessário
include("config.php");

// Verificar se o ID foi passado na URL
if (!isset($_REQUEST["id"]) || empty($_REQUEST["id"])) {
    die("ID do veículo não fornecido.");
}

$id = intval($_REQUEST["id"]); // Certifique-se de que o ID é um número inteiro

// Consulta SQL para obter os dados do veículo com o ID fornecido
$sql = "SELECT * FROM veiculo WHERE id=?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

// Verificar se o veículo foi encontrado
if ($res->num_rows === 0) {
    die("Veículo não encontrado.");
}

// Buscar o veículo
$wor = $res->fetch_object();
?>
<form action="salvar-usuario.php" method="POST">
    <input type="hidden" name="acao" value="editar"> <!-- Campo oculto para a ação -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($wor->id); ?>"> <!-- Campo oculto para o ID -->
    <div class="mb-3">
        <label for="placa" class="form-label">Placa</label>
        <input type="text" class="form-control" id="placa" name="placa" value="<?php echo htmlspecialchars($wor->placa); ?>" required>
    </div>
    <div class="mb-3">
        <label for="proprietario" class="form-label">Proprietário</label>
        <input type="text" class="form-control" id="proprietario" name="proprietario" value="<?php echo htmlspecialchars($wor->proprietario); ?>" required>
    </div>
    <div class="mb-3">
        <label for="modelo" class="form-label">Modelo</label>
        <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo htmlspecialchars($wor->modelo); ?>" required>
    </div>
    <div class="mb-3">
        <label for="cor" class="form-label">Cor</label>
        <input type="text" class="form-control" id="cor" name="cor" value="<?php echo htmlspecialchars($wor->cor); ?>" required>
    </div>
    <div class="mb-3">
        <label for="horario_entrada" class="form-label">Horário de Entrada</label>
        <input type="time" class="form-control" id="horario_entrada" name="horario_entrada" value="<?php echo htmlspecialchars($wor->horario_entrada); ?>" required>
    </div>
    <div class="mb-3">
        <label for="horario_saida" class="form-label">Horário de Saída</label>
        <input type="time" class="form-control" id="horario_saida" name="horario_saida" value="<?php echo htmlspecialchars($wor->horario_saida); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
<?php
// Fechar o resultado e a conexão
$res->close();
$conn->close();
?>
