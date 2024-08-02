<?php
include("init.php"); // Ajuste o caminho se necessário
include("config.php");

// Verifique se o usuário está autenticado e é um administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<p>Acesso negado. Você precisa ser um administrador para acessar esta página.</p>";
    exit();
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Novo Veículo</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h1 class="card-title mb-4">Novo Veículo</h1>
            <form action="salvar-usuario.php" method="POST">
              <input type="hidden" name="acao" value="cadastrar"> <!-- Campo oculto para a ação -->
              <div class="mb-3">
                <label for="placa" class="form-label">Placa</label>
                <input type="text" class="form-control" id="placa" name="placa" required>
              </div>
              <div class="mb-3">
                <label for="proprietario" class="form-label">Proprietário</label>
                <input type="text" class="form-control" id="proprietario" name="proprietario" required>
              </div>
              <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" required>
              </div>
              <div class="mb-3">
                <label for="cor" class="form-label">Cor</label>
                <input type="text" class="form-control" id="cor" name="cor" required>
              </div>
              <div class="mb-3">
                <label for="horario_entrada" class="form-label">Horário de Entrada</label>
                <input type="time" class="form-control" id="horario_entrada" name="horario_entrada" required>
              </div>
              <div class="mb-3">
                <label for="horario_saida" class="form-label">Horário de Saída</label>
                <input type="time" class="form-control" id="horario_saida" name="horario_saida" required>
              </div>
              <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
