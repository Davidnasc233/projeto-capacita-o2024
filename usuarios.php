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
  <title>Gerenciamento de usuários</title>
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
          <span>Gerenciamento de usuário</span>
        </a>
        <a href="cadastro-usuario.php" class="button-default bt-add">Adicionar novo usuários</a>
      </div>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>CPF</th>
              <th>E-mail</th>
              <th>Nasscimento</th>
              <th>Telefone</th>
              <th class="acao"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = 'SELECT * FROM usuarios';
            $usuarios = mysqli_query($conexao, $sql);
            if (mysqli_num_rows($usuarios) > 0) {
              foreach ($usuarios as $usuario) {
            ?>
          <tr>
              <td><?=$usuario['id']?></td>
              <td><?=$usuario['nome']?></td>
              <td><?=$usuario['cpf']?></td>
              <td><?=$usuario['email']?></td>
              <td><?=$usuario['nascimento']?></td>
              <td><?=$usuario['telefone']?></td>
              <td>
                <a href="usuario-edit.php?id=<?=$usuario['id']?>" class="btn btn-success btn-sm"> Editar</a>
                <form action="acoes-crud.php" method="POST" class="d-inline">
                <button onclick="return confirm('Tem certeza que deseja excluir?')" type="submit" name="delete_usuario" value="<?=$usuario['id']?>" class="btn btn-danger btn-sm">
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