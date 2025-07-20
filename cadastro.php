<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Cadastro</h2>
  <form method="POST">
    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
    <input type="password" name="senha" class="form-control mb-3" placeholder="Senha" required>
    <button type="submit" name="cadastrar" class="btn btn-success">Cadastrar</button>
    <a href="login.php" class="btn btn-link">Já tenho conta</a>
  </form>

  <?php
  if (isset($_POST['cadastrar'])) {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $senha);

    if ($stmt->execute()) {
      echo "<div class='alert alert-success mt-3'>Cadastro feito com sucesso!</div>";
    } else {
      echo "<div class='alert alert-danger mt-3'>Erro ao cadastrar!</div>";
    }
  }
  ?>
</body>
</html>
