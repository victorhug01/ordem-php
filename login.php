<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
  <div class="card p-4 shadow" style="min-width: 300px; max-width: 400px; width: 100%;">
    <h2 class="text-center mb-4">Login</h2>
    <?php
      if (isset($_POST['entrar'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $sql = $conn->prepare("SELECT * FROM usuarios WHERE email=?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();

        if ($result && password_verify($senha, $result['senha'])) {
          $_SESSION['usuario_id'] = $result['id'];
          header('Location: index.php');
        } else {
          echo "<div class='alert alert-danger mt-3'>Credenciais inválidas!</div>";
        }
      }
    ?>
    <form method="POST">
      <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
      <input type="password" name="senha" class="form-control mb-3" placeholder="Senha" required>
      <button type="submit" name="entrar" class="btn btn-primary w-100">Entrar</button>
      <a href="cadastro.php" class="btn btn-link w-100 text-center mt-2">Criar conta</a>
    </form>
  </div>

</body>
</html>
