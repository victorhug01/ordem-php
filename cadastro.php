<?php
include 'conexao.php';
mysqli_report(MYSQLI_REPORT_OFF); // Desativa exceções automáticas
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body { height: 100%; }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100 bg-light">

<div class="card p-4 shadow" style="min-width: 300px; max-width: 400px; width: 100%;">
  <h2 class="text-center mb-4">Cadastro</h2>

  <?php
  if (isset($_POST['cadastrar'])) {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    try {
      // Verifica se o e-mail já existe
      $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
      $check->bind_param("s", $email);
      $check->execute();
      $check->store_result();

      if ($check->num_rows > 0) {
        echo "<div class='alert alert-warning'>Este e-mail já está em uso.</div>";
      } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $senha);

        if ($stmt->execute()) {
          echo "<div class='alert alert-success'>Cadastro feito com sucesso!</div>";
        } else {
          echo "<div class='alert alert-danger'>Erro ao cadastrar!</div>";
        }
      }
    } catch (Exception $e) {
      echo "<div class='alert alert-danger'>Erro interno: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
  }
  ?>

  <form method="POST">
    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
    <input type="password" name="senha" class="form-control mb-3" placeholder="Senha" required>
    <button type="submit" name="cadastrar" class="btn btn-success w-100">Cadastrar</button>
    <a href="login.php" class="btn btn-link w-100 text-center mt-2">Já tenho conta</a>
  </form>
</div>

</body>
</html>
