<?php include 'conexao.php';
if (!isset($_SESSION['usuario_id'])) header('Location: login.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Início</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Bem-vindo!</h2>
    <a href="logout.php" class="btn btn-danger">Sair</a>
  </div>

  <div class="d-grid gap-3">
    <a href="produtos.php" class="btn btn-primary btn-lg">Gerenciar Produtos</a>
    <a href="ordens.php" class="btn btn-secondary btn-lg">Cadastrar Ordem de Serviço</a>
  </div>
</body>
</html>
