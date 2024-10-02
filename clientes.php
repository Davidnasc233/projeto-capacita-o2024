<?php
session_start(); 
include 'config.php';
$config = isset($config) ? $config : array();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciamento de cliente</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <header>
    <?php 
    require_once 'header.php';
    ?>
  </header>
  <section class="page-gerenciamento-cliente">
    <div class="container">
      <?php include ('mensagem.php'); ?>
      <div class="d-flex justify-content-between">
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Gerenciamento de cliente</span>
        </a>
        <a href="cadastro-cliente.php" class="button-default bt-add">Adicionar novo cliente</a>
      </div>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>CPF</th>
              <th>E-mail</th>
              <th>Telefone</th>
              <th class="acao"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = 'SELECT * FROM clientes';
            $clientes = mysqli_query($conexao, $sql);
            if (mysqli_num_rows($clientes) > 0) {
              foreach ($clientes as $cliente) {
            ?>
          <tr>
              <td><?=$cliente['id']?></td>
              <td><?=$cliente['nome']?></td>
              <td><?=$cliente['cpf']?></td>
              <td><?=$cliente['email']?></td>
              <td><?=$cliente['telefone']?></td>
              <td>
                <a href="cliente-edit.php?id=<?=$cliente['id']?>" class="btn btn-success btn-sm"> Editar</a>
                <form action="acoes-crud.php" method="POST" class="d-inline">
                <button onclick="return confirm('Tem certeza que deseja excluir?')" type="submit" name="delete_cliente" value="<?=$cliente['id']?>" class="btn btn-danger btn-sm">
                          <span class="bi-trash3-fill"></span>&nbsp;Excluir
                        </button>
                </form>
              </td>
            </tr>
            <?php
              }
            } else{
              echo'<h5>Nenhum usuário encontrado</h5>';
            }
           ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>

</html>