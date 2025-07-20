<?php include 'conexao.php';
if (!isset($_SESSION['usuario_id'])) header('Location: login.php');

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
  $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Ordens</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Nova Ordem de Serviço</h2>
  <form method="POST">
    <input type="text" name="numero" class="form-control mb-2" placeholder="Número Ordem" required>
    <input type="date" name="data" class="form-control mb-2" required>
    <select name="produto_id" class="form-select mb-2" required>
      <option value="">Selecione o produto</option>
      <?php foreach ($produtos as $p): ?>
        <option value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
      <?php endforeach; ?>
    </select>
    <input type="text" name="nome" class="form-control mb-2" placeholder="Nome Consumidor" required>
    <input type="text" name="cpf" class="form-control mb-2" placeholder="CPF" required>
    <textarea name="defeito" class="form-control mb-2" placeholder="Defeito" required></textarea>
    <textarea name="solucao" class="form-control mb-2" placeholder="Solução"></textarea>
    <button class="btn btn-primary">Cadastrar Ordem</button>
  </form>
  <a href="index.php" class="btn btn-link mt-3">Voltar</a>
</body>
</html>
