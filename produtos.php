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
  <title>Gerenciamento de produto</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/gerenciamento_produto.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <header>
    <?php 
    require_once 'header.php';
    ?>
  </header>
  <section class="page-gerenciamento-produto">
    <div class="container">
      <div class="d-flex justify-content-between">
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Gerenciamento de produto</span>
        </a>
        <a href="cadastro-produto.php" class="bt-add">Adicionar novo produto</a>
      </div>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Imagem</th>
              <th>Nome</th>
              <th>SKU</th>
              <th>QNTD</th>
              <th>Descrição</th>
              <th>Valor</th>
              <th class="acao"></th>
            </tr>
          </thead>
          <tbody>
          <?php
            $sql = 'SELECT * FROM produtos';
            $produtos = mysqli_query($conexao, $sql);
            if (mysqli_num_rows($produtos) > 0) {
              foreach ($produtos as $produto) {
            ?>
            <tr>
              <td><?=$produto['id']?></td>
              <td>
                <img src="<?php echo "uploads/".$produto['image']; ?>" class="img-produto" alt="Imagem do produto" />
            </td>
              <td><?=$produto['nome']?></td>
              <td><?=$produto['sku']?></td>
              <td><?=$produto['quantidade']?></td>
              <td><span class="descr"><?=$produto['descricao']?></span></td>
              <td>R$ <?= number_format($produto['quantidade'] * $produto['valor'], 2, ',', '.') ?></td>
              <td>
                <a href="produto-edit.php?id=<?=$produto['id']?>" class="btn btn-success btn-sm"> Editar</a>
                <form action="acoes-crud.php" method="POST" class="d-inline">
                <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                <button onclick="return confirm('Tem certeza que deseja excluir?')" type="submit" name="delete_produto" value="<?=$produto['id']?>" class="btn btn-danger btn-sm">
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