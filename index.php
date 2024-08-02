<?php
session_start(); // Apenas uma chamada de session_start() deve estar aqui
include_once("config.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Cadastro</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-3 m-0 border-0 bd-example m-0 border-0">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Cadastro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link" href="?page=novo">Novo Veículo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=gerenciar">Gerenciar Usuários</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link" href="?page=listar">Lista de Veículos</a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col mt-5">
          <?php
              switch(@$_REQUEST["page"]){
                case "novo":
                  include("novo-usuario.php");
                  break;
                case "listar":
                  include("listar-usuario.php");
                  break;
                case "salvar":
                  include("salvar-usuario.php");
                  break;
                case "editar":
                  include("editar-usuario.php");
                  break;
                case "gerenciar":
                  include("gerenciar-usuarios.php");
                  break;
                default:
                  print "<h1>Bem Vindo!</h1>";
              }
          ?>
        </div>
      </div>
    </div>
</body>
</html>
