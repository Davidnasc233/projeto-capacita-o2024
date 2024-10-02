<?php
session_start(); 
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_id = $_POST['produto_id'];
    $quantidade_pedido = $_POST['quantidade'];

    // Verifica se a quantidade é válida
    if ($quantidade_pedido <= 0) {
        $_SESSION['mensagem_erro'] = "Quantidade inválida!";
        header('Location: pedidos.php');
        exit();
    }

    // Busca o produto no banco de dados
    $sql = "SELECT * FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $produto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $produto = $resultado->fetch_assoc();

    if ($produto) {
        $quantidade_estoque = $produto['quantidade'];

        // Verifica se há quantidade suficiente no estoque
        if ($quantidade_estoque >= $quantidade_pedido) {
            // Calcula a nova quantidade
            $nova_quantidade = $quantidade_estoque - $quantidade_pedido;

            // Atualiza o banco de dados com a nova quantidade
            $sql_update = "UPDATE produtos SET quantidade = ? WHERE id = ?";
            $stmt_update = $conexao->prepare($sql_update);
            $stmt_update->bind_param('ii', $nova_quantidade, $produto_id);

            if ($stmt_update->execute()) {
                // Redireciona com mensagem de sucesso
                $_SESSION['mensagem_sucesso'] = "Pedido realizado com sucesso!";
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao atualizar o estoque!";
            }

            $stmt_update->close();
        } else {
            $_SESSION['mensagem_erro'] = "Estoque insuficiente!";
        }
    } else {
        $_SESSION['mensagem_erro'] = "Produto não encontrado!";
    }

    $stmt->close();
    $conexao->close();

    // Redireciona para a página de pedidos
    header('Location: pedidos.php');
    exit();
}
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
          <span>Estoque</span>
        </a>
        <a></a>
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
              <td>R$ <?= number_format($produto['quantidade'] * $produto['valor'], 2, ',', '.') ?></td>
              <td>
               
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