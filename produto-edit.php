<?php

include_once('config.php');


?>

<!DOCTYPE php>
<php lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar produto</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/cadastro_produto.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
    <header>
      <?php 
          require_once 'header.php';
          ?>
  </header>
  <section class="page-cadastro-produto paddingBottom50">
    <div class="container">
      <div>
        <a href="produtos.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Editar produto</span>
        </a>
      </div>
      <div class="container-small">
      <?php
        if (isset($_GET['id'])) {
            $produto_id = mysqli_real_escape_string($conexao, $_GET['id']);
            $sql = "SELECT * FROM produtos WHERE id='$produto_id'";
            $query = mysqli_query($conexao, $sql);

            if (mysqli_num_rows($query) > 0) {
                $produtos = mysqli_fetch_array($query);
        ?>
      <form action="acoes-crud.php" method="post" id="form-cadastro-produto" enctype="multipart/form-data">
  <input type="hidden" name="produto_id" value="<?=$produto_id?>">
  <div class="bloco-inputs">
    <div>
      <label class="input-label">Nome</label>
      <input type="text" value="<?=$produtos['nome']?>" class="nome-input" name="nome">
    </div>
    <div>
      <label class="input-label">Descrição</label>
      <textarea class="textarea" name="descricao"><?=$produtos['descricao']?></textarea>
    </div>
    <div class="flex-2">
      <div>
        <label class="input-label">SKU</label>
        <input type="text" value="<?=$produtos['sku']?>" class="sku-input" name="sku">
      </div>
      <div>
        <label class="input-label">Quantidade</label>
        <input type="text" value="<?=$produtos['quantidade']?>" class="valor-input" name="quantidade">
      </div>
      <div>
        <label class="input-label">Valor</label>
        <input type="text" value="<?=$produtos['valor']?>" class="valor-input" name="valor">
      </div>
    </div>
    <div>
      <label class="bt-arquivo" for="bt-arquivo">Nova imagem</label>
      <input id="bt-arquivo" type="file" name="imagem">
    </div>
  </div>
  <button type="submit" class="button-default" name="update_produto">Atualizar</button>
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

</php>