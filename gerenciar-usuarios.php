<?php
session_start();
include("config.php");

// Verificar se o usuário está logado e se é admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Você deve ser um administrador para acessar esta página.");
}

// Consulta SQL para obter todos os usuários
$sql = "SELECT id, username, role FROM usuarios";
$res = $conn->query($sql);

// Verifica o número de linhas retornadas
$qdt = $res->num_rows;

?>
<h1>Gerenciar Usuários</h1>

<?php
if ($qdt > 0) {
    echo "<table class='table table-hover table-striped table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nome de Usuário</th>";
    echo "<th>Função</th>";
    echo "<th>Ações</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Loop para processar cada linha retornada
    while ($user = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
        echo "<td>
            <form action='alterar-permissao.php' method='POST' style='display:inline;'>
                <input type='hidden' name='user_id' value='" . htmlspecialchars($user['id']) . "'>
                <select name='role'>
                    <option value='user'" . ($user['role'] === 'user' ? ' selected' : '') . ">Usuário</option>
                    <option value='admin'" . ($user['role'] === 'admin' ? ' selected' : '') . ">Administrador</option>
                </select>
                <button type='submit' class='btn btn-primary'>Alterar</button>
            </form>
            </td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p class='alert alert-danger'>Não há usuários para exibir.</p>";
}

// Fechar o resultado e a conexão
$res->close();
$conn->close();
?>
