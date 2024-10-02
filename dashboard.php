<?php
  session_start();
  // print_r($_SESSION);
  include 'config.php';
  if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
  {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: index.php');
  }
  $logado = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/index.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
  <header>
    <?php
    require_once 'header.php';
    ?>
  </header>
  <section class="page-index">
    <div class="container">
      <div class="dash-index">
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Clientes</h2>
              <span><?php echo $totalClientes?></span>
            </div>
            <img src="assets/images/icon-users.svg" alt="">
          </div>
          <a href="clientes.php" class="bt-index">Gerenciar clientes</a>
        </div>
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Produtos</h2>
              <span><?php echo $totalProdutos?></span>
            </div>
            <img src="assets/images/icon-product.svg" style="max-width: 76px;" alt="">
          </div>
          <a href="produtos.php" class="bt-index">Gerenciar produto</a>
        </div>
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Pedidos</h2>
              <span></span>
            </div>
            <img src="assets/images/icon-pedido.svg" alt="">
          </div>
          <a href="pedidos.php" class="bt-index">Novo pedido</a>
        </div>
      </div>
    </div>
  </section>

  <section class="page-index">
    <div class="container">
      <div class="dash-index">
      <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Usuários</h2>
              <span><?php echo $totalUsuarios?></span>
            </div>
            <img src="assets/images/icon-users.svg" alt="">
          </div>
          <a href="usuarios.php" class="bt-index">Gerenciar Usuários</a>
        </div>
      <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Estoque</h2>
              <span></span>
            </div>
            <img src="assets/images/box-svgrepo-com.svg" alt="">
          </div>
          <a href="estoque.php" class="bt-index">Ver Estoque</a>
        </div>
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Senha</h2>
              <span></span>
            </div>
            <img src="assets/images/password-2-svgrepo-com.svg" alt="">
          </div>
          <a href="alterar-senha.php" class="bt-index">Alterar senha</a>
        </div>
      </div>

      </div>
    </div>
  </section>
</body>

</html>