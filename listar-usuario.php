<?php
include("config.php");

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    die("Você deve estar logado para acessar esta página.");
}

// Verificar o nível de acesso do usuário
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Consulta SQL para selecionar todos os veículos
$sql = "SELECT * FROM veiculo";

// Executa a consulta
$res = $conn->query($sql);

// Verifica o número de linhas retornadas
$qdt = $res->num_rows;

if ($qdt > 0) {
    // Cria a tabela para exibir os dados
    echo "<table class='table table-hover table-striped table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>Placa</th>";
    echo "<th>Proprietário</th>";
    echo "<th>Modelo</th>";
    echo "<th>Cor</th>";
    echo "<th>Horário de Entrada</th>";
    echo "<th>Horário de Saída</th>";

    if ($is_admin) {
        echo "<th>Ações</th>";
    }

    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Loop para processar cada linha retornada
    while ($wor = $res->fetch_object()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($wor->id) . "</td>";
        echo "<td>" . htmlspecialchars($wor->placa) . "</td>";
        echo "<td>" . htmlspecialchars($wor->proprietario) . "</td>";
        echo "<td>" . htmlspecialchars($wor->modelo) . "</td>";
        echo "<td>" . htmlspecialchars($wor->cor) . "</td>";
        echo "<td>" . htmlspecialchars($wor->horario_entrada) . "</td>";
        echo "<td>" . htmlspecialchars($wor->horario_saida) . "</td>";

        if ($is_admin) {
            echo "<td>
                <button onclick=\"location.href='?page=editar&id=" . htmlspecialchars($wor->id) . "'\" class='btn btn-success'>Editar</button>
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='salvar-usuario.php?acao=excluir&id=" . htmlspecialchars($wor->id) . "';}\" class='btn btn-danger'>Excluir</button>
                </td>";
        }

        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
} else {
    // Mensagem quando não há resultados
    echo "<p class='alert alert-danger'>Não encontrou resultados!</p>";
}

// Fechar o resultado e a conexão
$res->close();
$conn->close();
?>
