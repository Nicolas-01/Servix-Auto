<?php
session_start();
if (!$_SESSION['acesso']) {
  header('location: index.php?mensagem=acesso_negado');
  // se o usuário digitar na url "principal.php"
  // o sistema verifica se esta logado, caso não esteja, retorna para index.php com uma mensagem de erro.
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agendamento - Servix Auto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- tabela em javaScript -->
  <link href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="Docs/calendario.ico" rel="shortcut icon">
  <link href="style.css" rel="stylesheet">
</head>

<body class="cabecalho">

  <nav class="navbar navbar-expand-lg navbar-customizada">
    <div class="container-fluid">
      <a class="navbar-brand" href="principal.php">Agendamento de Serviços</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="servico.php">Serviços</a></li>
          <li class="nav-item"><a class="nav-link" href="agendamento.php">Agendamentos</a></li>
          <li class="nav-item"><a class="nav-link" href="profissional.php">Profissionais</a></li>
          <li class="nav-item"><a class="nav-link" href="clientes.php">Clientes</a></li>
          <li class="nav-item"><a class="nav-link" href="relatorio.php">Relatórios</a></li>
        </ul>

        <div class="d-flex ms-auto">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-person-circle"></i> <?= $_SESSION['usuario'] ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="alterar_dados.php">Alterar Dados</a></li>
                <li><a class="dropdown-item btn btn-danger" href="sair.php" id="logoutButton">Sair</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </nav>

  <main class="container"></main>