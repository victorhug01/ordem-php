<?php 
include 'conexao.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['msg']);

if (!isset($_SESSION['usuario_id'])) {
  header('Location: login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $codigo = $_POST['codigo'];
  $nome = $_POST['nome'];
  $garantia = $_POST['garantia'];
  $status = isset($_POST['status']) ? 1 : 0;

  $stmt = $conn->prepare("INSERT INTO produtos (codigo, nome, tempo_garantia, status) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssii", $codigo, $nome, $garantia, $status);

  if ($stmt->execute()) {
    $_SESSION['msg'] = ['type' => 'success', 'text' => 'Produto cadastrado com sucesso!'];
  } else {
    $_SESSION['msg'] = ['type' => 'danger', 'text' => 'Erro ao cadastrar produto.'];
  }

  header("Location: produtos.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Produtos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      max-width: 500px;
      width: 100%;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">

  <div class="card shadow p-4">
    <h4 class="text-center mb-3">Cadastro de Produtos</h4>

    <?php if ($msg): ?>
      <div class="alert alert-<?= htmlspecialchars($msg['type']) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg['text']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
      </div>
    <?php endif; ?>

    <form method="POST" class="needs-validation" novalidate>
      <div class="mb-3">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ex: PROD-001" required>
      </div>

      <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Produto" required>
      </div>

      <div class="mb-3">
        <label for="garantia" class="form-label">Garantia (em meses)</label>
        <input type="number" name="garantia" id="garantia" class="form-control" placeholder="Ex: 12" required>
      </div>

      <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" name="status" id="status">
        <label class="form-check-label" for="status">Produto Ativo</label>
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-success">Cadastrar Produto</button>
        <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
