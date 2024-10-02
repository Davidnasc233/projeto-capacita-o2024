<?php
include_once("config.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuário</title>
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
        <a href="usuarios.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Editar Usuário</span>
        </a>
      </div>
      <div class="container-small">
        <?php
        if (isset($_GET['id'])) {
            $usuario_id = mysqli_real_escape_string($conexao, $_GET['id']);
            $sql = "SELECT * FROM usuarios WHERE id='$usuario_id'";
            $query = mysqli_query($conexao, $sql);

            if (mysqli_num_rows($query) > 0) {
                $usuarios = mysqli_fetch_array($query);
        ?>
        <form action="acoes-crud.php" method="POST" id="form-cadastro-cliente">
            <input type="hidden" name="usuario_id" value="<?=$usuario_id?>">
          <div class="bloco-inputs">
            <div>
              <label class="input-label" for="nome">Nome</label>
              <input type="text" value="<?=$usuarios['nome']?>" class="nome-input" name="nome" id="m-nome">
            </div>
            <div>
              <label class="input-label" for="cpf">CPF</label>
              <input type="text" value="<?=$usuarios['cpf']?>" class="cpf-input" name="cpf" id="m-cpf">
            </div>
            <div>
              <label class="input-label" for="email">E-mail</label>
              <input type="text" value="<?=$usuarios['email']?>" class="email-input" name="email" id="m-email">
            </div>
            <div>
              <label class="input-label" for="nascimento">Nascimento</label>
              <input type="date" value="<?=$usuarios['nascimento']?>" class="email-input" name="nascimento" id="m-email">
            </div>
            <div>
              <label class="input-label" for="telefone">Telefone</label>
              <input type="tel" value="<?=$usuarios['telefone']?>" class="telefone-input" name="telefone" id="m-telefone">
            </div>
          </div>
          <button type="submit" class="button-default" name="update_usuario">Atualizar</button>
        </form>
        <?php
    } else {
            echo"<h5>Usuário não encontrado</h5>";
        }
    }
        ?>
      </div>
    </div>
  </section>
</body>
</html>