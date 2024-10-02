<?php
session_start();
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email'], $_SESSION['senha']);
    header('Location: dashboard.php');
    exit();
}

$logado = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nova_senha = $_POST['nova_senha'];

    // Criptografa a nova senha com hash sha1
    $senha_criptografada = hash('sha1', $nova_senha);

    // Atualiza a senha no banco de dados
    $sql = "UPDATE usuarios SET senha = ? WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ss', $senha_criptografada, $logado);

    if ($stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = "Senha alterada com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao alterar a senha.";
    }

    $stmt->close();
    $conexao->close();

    // Redireciona o usuário após a alteração
    header("Location: alterar-senha.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de cliente</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
  <header>
      <?php 
          require_once 'header.php';
          ?>
  </header>
  <section class="page-cadastro-cliente paddingBottom50">
    <div class="container">
      <div>
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Altere sua senha</span>
        </a>
      </div>
      <div class="container-small">
        <form action="alterar-senha.php" method="POST" id="form-cadastro-cliente">
          <div class="bloco-inputs">
            <div>
              <label class="input-label" for="email">E-mail</label>
              <input type="text" class="nome-input" name="email" id="m-nome" >
            </div>
            <div>
              <label class="input-label">Nova Senha</label>
              <input type="password" class="senha-input" name="novaSenha">
            </div>
          </div>
          <button type="submit" class="button-default" name="submit">Alterar senha</button>
        </form>
      </div>
    </div>
  </section>
</body>