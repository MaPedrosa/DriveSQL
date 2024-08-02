<?php
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id']) && isset($_POST['role'])) {
        $user_id = intval($_POST['user_id']);
        $role = $_POST['role'];
        
        // Valida se o papel é válido
        if ($role !== 'admin' && $role !== 'user') {
            die("Papel inválido.");
        }

        $sql = "UPDATE usuarios SET role = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $role, $user_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Papéis atualizados com sucesso.'); location.href='index.php?page=manage_users';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar papéis: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
}

$sql = "SELECT id, username, role FROM usuarios";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
    echo "<h1>Gerenciar Usuários</h1>";
    echo "<table class='table table-hover table-striped table-bordered'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nome de Usuário</th>";
    echo "<th>Papel</th>";
    echo "<th>Ação</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
        echo "<td>
            <form method='POST' style='display:inline;'>
                <input type='hidden' name='user_id' value='" . htmlspecialchars($row['id']) . "'>
                <select name='role'>
                    <option value='user'" . ($row['role'] == 'user' ? ' selected' : '') . ">Usuário</option>
                    <option value='admin'" . ($row['role'] == 'admin' ? ' selected' : '') . ">Administrador</option>
                </select>
                <button type='submit' class='btn btn-warning btn-sm'>Alterar</button>
            </form>
            </td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p class='alert alert-danger'>Nenhum usuário encontrado.</p>";
}

$res->close();
$conn->close();
?>
