<?php
session_start();
require_once 'config.php';
$config = isset($config) ? $config : array();

// Consulta de clientes
$sqlClientes = "SELECT id, nome FROM clientes";
$resultClientes = $conexao->query($sqlClientes);

// Consulta de produtos
$sqlProdutos = "SELECT id, nome, valor FROM produtos";
$resultProdutos = $conexao->query($sqlProdutos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtém os dados do formulário
  $cliente_id = $_POST['cliente_id']; // ID do cliente
  $produto_id = $_POST['produto_id']; // ID do produto
  $quantidade_solicitada = $_POST['quantidade']; // Quantidade solicitada

  // Verifica a quantidade disponível no estoque
  $stmt = $conexao->prepare("SELECT quantidade FROM produtos WHERE id = ?");
  $stmt->bind_param("i", $produto_id);
  $stmt->execute();
  $stmt->bind_result($quantidade);
  $stmt->fetch();
  $stmt->close();

  if ($quantidade >= $quantidade_solicitada) {
      // Subtrai a quantidade do estoque
      $nova_quantidade = $quantidade - $quantidade_solicitada;

      // Atualiza a quantidade no estoque
      $stmt = $conexao->prepare("UPDATE produtos SET quantidade = ? WHERE id = ?");
      $stmt->bind_param("ii", $nova_quantidade, $produto_id);
      $stmt->execute();
      $stmt->close();

      // Insere o pedido na tabela novo_pedido
      $stmt = $conexao->prepare("INSERT INTO novo_pedido (cliente_id, produto_id, quantidade) VALUES (?, ?, ?)");
      $stmt->bind_param("iii", $cliente_id, $produto_id, $quantidade_solicitada);
      if ($stmt->execute()) {
          $_SESSION['mensagem_sucesso'] = "Pedido realizado com sucesso!";
      } else {
          $_SESSION['mensagem_erro'] = "Erro ao realizar o pedido: " . $stmt->error;
      }
      $stmt->close();
  } else {
      $_SESSION['mensagem_erro'] = "Quantidade solicitada não disponível em estoque.";
  }

  $conexao->close();
  header("Location: pedidos.php"); // Redireciona para evitar reenvio do formulário
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo pedido</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="./assets/css/novo_pedido.css">
    <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
    <script async src="pedido.js"></script>
</head>

<body>
    <header>
        <?php require_once 'header.php'; ?>
    </header>

    <section class="page-novo-pedido paddingBottom50">
        <div class="container">
            <div>
                <a href="dashboard.php" class="link-voltar">
                    <img src="assets/images/arrow.svg" alt="">
                    <span>Novo pedido</span>
                </a>
            </div>
            <form id="form-pedido" method="POST" action="salvar_pedido.php">
                <!-- Seção de clientes -->
                <div class="maxW340">
                    <label class="input-label">Cliente</label>
                    <select class="input" name="cliente" id="cliente" required>
                        <?php
                        if ($resultClientes->num_rows > 0) {
                            while ($cliente = $resultClientes->fetch_assoc()) {
                                echo "<option value='" . $cliente['id'] . "'>" . $cliente['nome'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Nenhum cliente encontrado</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Tabela de produtos -->
                <div class="shadow-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor parcial</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="productRows">
                            <tr>
                                <td>
                                    <select class="input" name="produto" onchange="atualizarValor(this)" required>
                                        <option value="">Selecione um produto</option>
                                        <?php
                                        if ($resultProdutos->num_rows > 0) {
                                            while ($produto = $resultProdutos->fetch_assoc()) {
                                                echo "<option value='" . $produto['id'] . "' data-preco='" . $produto['valor'] . "'>" . $produto['nome'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Nenhum produto encontrado</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><input type="number" class="input" name="quantidade" value="1" oninput="atualizarValor(this)" min="1"></td>
                                <td><input type="text" class="input" name="valorParcial" disabled value="0,00"></td>
                                <td><a href="#" class="bt-remover" onclick="removerProduto(this)"><img src="assets/images/remover.svg" alt="" /></a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col">
                                            <a href="#" class="bt-add-produto" onclick="adicionarProduto()">
                                                <span>Adicionar produto</span>
                                                <img src="assets/images/adicionar.svg" alt="" />
                                            </a>
                                        </div>
                                        <div class="blc-subtotal d-flex">
                                            <div class="d-flex align-items-center">
                                                <span>Subtotal</span>
                                                <input type="text" class="input" id="subtotal" name="subtotal" disabled value="0,00" />
                                                <input type="hidden" id="subtotalHidden" name="subtotal" value="0.00" />
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span>Desconto (10%)</span>
                                                <input type="text" class="input" id="desconto" name="desconto" disabled value="0,00" />
                                                <input type="hidden" id="descontoHidden" name="desconto" value="0.00" />
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span>Total</span>
                                                <input type="text" class="input" id="total" name="total" disabled value="0,00" />
                                                <input type="hidden" id="totalHidden" name="total" value="0.00" />
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="maxW340">
                    <label class="input-label">Observação</label>
                    <input type="text" class="input" name="observacao">
                </div>
                <div class="maxW340">
                    <button type="submit" name="submit" class="button-default">Salvar</button>
                </div>
            </form>
        </div>
    </section>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
        atualizarTotal(); // Atualiza o total quando a página carrega
    });

    // Função para adicionar uma nova linha de produto
    function adicionarProduto() {
        const tabela = document.getElementById('productRows');
        const novaLinha = `
            <tr>
              <td>
                <select class="input" name="produto" onchange="atualizarValor(this)">
                  ${document.querySelector("select[name='produto']").innerHTML} <!-- Copia as opções de produto -->
                </select>
              </td>
              <td><input type="number" class="input" name="quantidade" value="1" oninput="atualizarValor(this)"></td>
              <td><input type="text" class="input" name="valorParcial" disabled value="0,00"></td>
              <td><a href="#" class="bt-remover" onclick="removerProduto(this)"><img src="assets/images/remover.svg" alt="" /></a></td>
            </tr>
        `;
        tabela.insertAdjacentHTML('beforeend', novaLinha); // Adiciona a nova linha
        atualizarTotal(); // Atualiza os valores após adicionar a linha
    }

    // Função para remover uma linha de produto
    function removerProduto(link) {
        link.closest('tr').remove(); // Remove a linha inteira
        atualizarTotal(); // Atualiza os valores após remover a linha
    }

    // Função para atualizar o valor parcial de cada produto
    function atualizarValor(elemento) {
        const linha = elemento.closest('tr');
        const selectProduto = linha.querySelector("select[name='produto']");
        const preco = parseFloat(selectProduto.options[selectProduto.selectedIndex].dataset.preco || 0); // Preço do produto
        const quantidade = parseInt(linha.querySelector("input[name='quantidade']").value); // Quantidade do produto
        
        // Calcula o valor parcial
        const valorParcial = preco * quantidade;
        linha.querySelector("input[name='valorParcial']").value = valorParcial.toFixed(2).replace(".", ",");

        atualizarTotal(); // Atualiza o subtotal e total após cada mudança
    }

    // Função para calcular o subtotal e o total
    function atualizarTotal() {
        let subtotal = 0;

        // Soma os valores parciais de cada produto
        document.querySelectorAll("input[name='valorParcial']").forEach(function(input) {
            subtotal += parseFloat(input.value.replace(",", ".")) || 0; // Evita NaN para campos vazios
        });

        // Atualiza o campo subtotal
        document.getElementById('subtotal').value = subtotal.toFixed(2).replace(".", ",");

        calcularTotal(); // Calcula o total com desconto
    }

    // Função para calcular o total com desconto de 10%
    function calcularTotal() {
        const subtotal = parseFloat(document.getElementById('subtotal').value.replace(",", "."));
        
        // Calcula 10% de desconto
        const desconto = subtotal * 0.10;
        
        // Atualiza o campo de desconto com o valor calculado
        document.getElementById('desconto').value = desconto.toFixed(2).replace(".", ",");

        // Calcula o total final (subtotal - desconto)
        const total = subtotal - desconto;

        // Atualiza o campo total
        document.getElementById('total').value = total.toFixed(2).replace(".", ",");
    }
    document.getElementById("pedidoForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Previne o envio normal do formulário

    // Captura os dados do formulário
    var formData = new FormData(this);

    // Envia os dados via AJAX
    fetch("pedidos.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Pedido registrado com sucesso!");
            window.location.href = "pedidos.php"; // Redireciona ou atualiza a página conforme necessário
        } else {
            alert("Erro: " + data.error);
        }
    })
    .catch(error => console.error("Erro:", error));
});
  </script>
</body>

</html>
