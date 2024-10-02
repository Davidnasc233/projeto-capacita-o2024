<?php
  session_start();
  if(isset($_POST['submit']))
  {
      include_once('config.php');

      $nome = $_POST['nome'];
      $sku= $_POST['sku'];
      $quantidade = $_POST['quantidade'];
      $descricao = $_POST['descricao'];
      $valor = $_POST['valor'];
      $image = $_FILES['image']['name'];

     $insert_image_query = "INSERT INTO produtos(nome,sku,quantidade,descricao,valor,image) VALUES ('$nome','$sku','$quantidade','$descricao','$valor','$image')";
     $insert_image_query_run = mysqli_query($conexao, $insert_image_query);


    if($insert_image_query_run) {
      move_uploaded_file($_FILES["image"]["tmp_name"],"uploads/".$_FILES["image"]["name"]);
      $_SESSION['status'] ="imagem salva com sucesso";
      header('location: produtos.php');
    } else {
      $_SESSION['status'] = "imagem não foi salva corretamente";
      header('location: cadastro-produto.php');
    }
  }

?>

<!DOCTYPE php>
<php lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de produto</title>
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
          <span>Cadastro de produto</span>
        </a>
      </div>
      <div class="container-small">
        <form action="cadastro-produto.php" method="post" id="form-cadastro-produto" enctype="multipart/form-data">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome</label>
              <input type="text" class="nome-input" name="nome">
            </div>
            <div>
              <label class="input-label">Descrição</label>
              <textarea class="textarea" name="descricao"></textarea>
            </div>
            <div class="flex-2">
              <div>
                <label class="input-label">SKU</label>
                <input type="text" class="sku-input" name="sku">
              </div>
              <div>
                <label class="input-label">Quantidade</label>
                <input type="text" class="valor-input" name="quantidade">
              </div>
              <div>
                <label class="input-label">Valor</label>
                <input type="text" class="valor-input" name="valor">
              </div>
            </div>
            <div>
              <label class="bt-arquivo" for="bt-arquivo">Adicionar imagem</label>
              <input id="bt-arquivo" type="file" name="image">
            </div>
          </div>
          <button type="submit" class="button-default" name="submit">Salvar novo produto</button>
</form>
      </div>
    </div>
  </section>
</body>

</php>