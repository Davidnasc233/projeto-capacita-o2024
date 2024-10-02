<?php
  // Definindo as credenciais de acesso ao banco de dados
  $dbHost = 'Localhost';        // Nome do host (geralmente 'localhost' para servidores locais)
  $dbUsername = 'root';         // Usuário do MySQL (por padrão no XAMPP, o usuário é 'root')
  $dbPassword = '';             // Senha do MySQL (em ambientes locais, a senha geralmente é vazia)
  $dbName = 'cadastro_usuario'; // Nome do banco de dados que você criou no phpMyAdmin

  // Criando a conexão
  $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conexao->connect_error) {
  die(''. $conexao->connect_error);
}

$sql = "SELECT COUNT(*) AS totalClientes FROM clientes";
$result = $conexao->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $totalClientes = $row['totalClientes'];
} else {
    $totalClientes = 0;
}

$sql = "SELECT COUNT(*) AS totalProdutos FROM produtos";
$result = $conexao->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $totalProdutos = $row['totalProdutos'];
} else {
  $totalProdutos = 0;
}

$sql = "SELECT COUNT(*) AS totalUsuarios FROM usuarios";
$result = $conexao->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $totalUsuarios = $row['totalUsuarios'];
} else {
  $totalUsuarios = 0;
}

// $sql = "SELECT COUNT(*) AS totalPedidos FROM pedidos";
// $result = $conexao->query($sql);
// if ($result) {
//     $row = $result->fetch_assoc();
//     $totalPedidos = $row['totalPedidos'];
// } else {
//   $totalPedidos = 0;
// }

