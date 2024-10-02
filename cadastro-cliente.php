<?php

  if(isset($_POST['submit']))
  {
      include_once('config.php');

      $nome = $_POST['nome'];
      $cpf= $_POST['cpf'];
      $email = $_POST['email'];
      $telefone = $_POST['telefone'];

      $result = mysqli_query($conexao, "INSERT INTO clientes(nome,cpf,email,telefone) VALUES ('$nome','$cpf','$email','$telefone')");

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
        <a href="clientes.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Cadastro de cliente</span>
        </a>
      </div>
      <div class="container-small">
        <form action="cadastro-cliente.php" method="POST" id="form-cadastro-cliente">
          <div class="bloco-inputs">
            <div>
              <label class="input-label" for="nome">Nome</label>
              <input type="text" class="nome-input" name="nome" id="m-nome" required>
            </div>
            <div>
              <label class="input-label" for="cpf">CPF</label>
              <input type="text" class="cpf-input" name="cpf" id="m-cpf" required>
            </div>
            <div>
              <label class="input-label" for="email">E-mail</label>
              <input type="text" class="email-input" name="email" id="m-email" required>
            </div>
            <div>
              <label class="input-label" for="telefone">Telefone</label>
              <input type="tel" class="telefone-input" name="telefone" id="m-telefone" required>
            </div>
          </div>
          <button type="submit" class="button-default" name="submit">Salvar novo cliente</button>
        </form>
      </div>
    </div>
  </section>
</body>

</php>