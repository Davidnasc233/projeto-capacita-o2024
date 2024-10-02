<?php

  if(isset($_POST['submit']))
  {
      include_once('config.php');

      $nome = $_POST['nome'];
      $email = $_POST['email'];
      $nascimento = $_POST['nascimento'];
      $cpf= $_POST['cpf'];
      $telefone = $_POST['telefone'];
      $senha = sha1($_POST['senha']);

      $result = mysqli_query($conexao, "INSERT INTO usuarios(nome,email,nascimento,cpf,telefone,senha) VALUES ('$nome','$email','$nascimento','$cpf','$telefone','$senha')");

  }
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de usuário</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
    <header>
    <div class="container">
      <a href="index.php" class="logo">
        <img src="assets/images/ho.svg" alt="" />
      </a>
    </div>
  </header>
  <section class="page-cadastro-usuario paddingBottom50">
    <div class="container">
      <div>
        <a href="index.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Cadastro de usuário</span>
        </a>
      </div>
      <div class="container-small">
        <form action = "cadastro-usuario.php" method="POST" id="form-cadastro-usuario">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome Completo</label>
              <input type="text" class="nome-input" name="nome">
            </div>
            <div>
              <label class="input-label">E-mail</label>
              <input type="text" class="email-input" name="email">
            </div>
            <div>
              <label class="input-label">Nascimento</label>
              <input type="date" class="senha-input" name="nascimento">
            </div>
            <div>
              <label class="input-label">CPF</label>
              <input type="text" class="cpf-input" name="cpf">
            </div>
            <div>
              <label class="input-label">Telefone</label>
              <input type="tel" class="telefone-input" name="telefone">
            </div>
            <div>
              <label class="input-label">Senha</label>
              <input type="password" class="senha-input" name="senha">
            </div>
          </div>
          <button type="submit" class="button-default" name="submit">Salvar novo usuário</button>
        </form>
      </div>
    </div>
  </section>
</body>

</php>