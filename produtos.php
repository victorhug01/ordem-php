<?php 
include 'conexao.php';
$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['msg']);

if (!isset($_SESSION['usuario_id'])) header('Location: login.php');

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
  <title>Produtos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Cadastro de Produtos</h2>
  <form method="POST">
    <input type="text" name="codigo" class="form-control mb-2" placeholder="Código" required>
    <input type="text" name="nome" class="form-control mb-2" placeholder="Nome" required>
    <input type="number" name="garantia" class="form-control mb-2" placeholder="Garantia (meses)" required>
    <div class="form-check mb-2">
      <input class="form-check-input" type="checkbox" name="status" id="status">
      <label class="form-check-label" for="status">Ativo</label>
    </div>
    <button class="btn btn-success">Cadastrar</button>
  </form>
  <a href="index.php" class="btn btn-link mt-3">Voltar</a>
</body>
</html>
