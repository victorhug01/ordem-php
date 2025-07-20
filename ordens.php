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

$produtos = $conn->query("SELECT * FROM produtos")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $stmt = $conn->prepare("INSERT INTO ordens_servico (numero_ordem, data_abertura, nome_consumidor, cpf_consumidor, defeito_reclamado, solucao_tecnico, produto_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssii",
    $_POST['numero'],
    $_POST['data'],
    $_POST['nome'],
    $_POST['cpf'],
    $_POST['defeito'],
    $_POST['solucao'],
    $_POST['produto_id'],
    $_SESSION['usuario_id']
  );

  if ($stmt->execute()) {
    $_SESSION['msg'] = ['type' => 'success', 'text' => 'Ordem cadastrada com sucesso!'];
  } else {
    $_SESSION['msg'] = ['type' => 'danger', 'text' => 'Erro ao cadastrar ordem.'];
  }

  header("Location: ordens.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Ordem de Serviço</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      max-width: 600px;
      width: 100%;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">

  <div class="card shadow p-4">
    <h4 class="text-center mb-3">Cadastro de Ordem de Serviço</h4>

    <?php if ($msg): ?>
      <div class="alert alert-<?= htmlspecialchars($msg['type']) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg['text']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
      </div>
    <?php endif; ?>

    <form method="POST" class="needs-validation" novalidate>
      <div class="mb-3">
        <label for="numero" class="form-label">Número da Ordem</label>
        <input type="text" name="numero" id="numero" class="form-control" placeholder="Ex: 12345" required>
      </div>

      <div class="mb-3">
        <label for="data" class="form-label">Data de Abertura</label>
        <input type="date" name="data" id="data" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="produto_id" class="form-label">Produto</label>
        <select name="produto_id" id="produto_id" class="form-select" required>
          <option value="">Selecione o produto</option>
          <?php foreach ($produtos as $p): ?>
            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="nome" class="form-label">Nome do Consumidor</label>
        <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome completo" required>
      </div>

      <div class="mb-3">
        <label for="cpf" class="form-label">CPF</label>
        <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00" required>
      </div>

      <div class="mb-3">
        <label for="defeito" class="form-label">Defeito Reclamado</label>
        <textarea name="defeito" id="defeito" class="form-control" placeholder="Descreva o defeito" required></textarea>
      </div>

      <div class="mb-3">
        <label for="solucao" class="form-label">Solução Técnica</label>
        <textarea name="solucao" id="solucao" class="form-control" placeholder="Descreva a solução (opcional)"></textarea>
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Cadastrar Ordem</button>
        <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
