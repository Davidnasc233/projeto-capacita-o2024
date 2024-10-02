<?php
session_start(); 
include 'config.php';
$config = isset($config) ? $config : array();

//CRUD Clientes

if (isset($_POST['create_usuario'])) {
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $telefone = mysqli_real_escape_string($conexao, trim($_POST['telefone']));

    $sql = "INSERT INTO clientes (nome, cpf, email, telefone) VALUES ('$nome', '$cpf', '$email', '$telefone')";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Usuário criado com sucesso.';
        header('Location: clientes.php');
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi criado.';
        header('Location: clientes.php');
        exit;
    }
}

if (isset($_POST['update_cliente'])) {
    $cliente_id = mysqli_real_escape_string($conexao, trim($_POST['cliente_id']));

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $telefone = mysqli_real_escape_string($conexao, trim($_POST['telefone']));

    $sql = "UPDATE clientes 
            SET nome='$nome', cpf='$cpf', email='$email', telefone='$telefone' 
            WHERE id='$cliente_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Usuário atualizado com sucesso.';
        header('Location: clientes.php');
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi atualizado.';
        header('Location: clientes.php');
        exit;
    }
}

if (isset($_POST['delete_cliente'])) {
	$cliente_id = mysqli_real_escape_string($conexao, $_POST['delete_cliente']);
	$sql = "DELETE FROM clientes WHERE id = '$cliente_id'";
	mysqli_query($conexao, $sql);
	if (mysqli_affected_rows($conexao) > 0) {
		$_SESSION['message'] = 'cliente deletado com sucesso';
		header('Location: clientes.php');
		exit;
	} else {
		$_SESSION['message'] = 'cliente não foi deletado';
		header('Location: clientes.php');
		exit;
	}
}

//CRUD produtos

if (isset($_POST['create_produto'])) {
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $descricao = mysqli_real_escape_string($conexao, trim($_POST['descricao']));
    $sku = mysqli_real_escape_string($conexao, trim($_POST['sku']));
    $quantidade = mysqli_real_escape_string($conexao, trim($_POST['quantidade']));
    $valor = mysqli_real_escape_string($conexao, trim($_POST['valor']));
    $imagem = mysqli_real_escape_string($conexao, trim($_POST['imagem']));

    $sql = "INSERT INTO produtos (nome, descricao, sku, quantidade, valor, imagem) VALUES ('$nome', '$descricao', '$sku', '$quantidade', '$valor', '$imagem')";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Produto criado com sucesso.';
        header('Location: produtos.php');
    } else {
        $_SESSION['mensagem'] = 'Produto não foi criado.';
        header('Location: produtos.php');
        exit;
    }
}

if (isset($_POST['update_produto'])) {
    $produto_id = mysqli_real_escape_string($conexao, trim($_POST['produto_id']));

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $descricao = mysqli_real_escape_string($conexao, trim($_POST['descricao']));
    $sku = mysqli_real_escape_string($conexao, trim($_POST['sku']));
    $quantidade = mysqli_real_escape_string($conexao, trim($_POST['quantidade']));
    $valor = mysqli_real_escape_string($conexao, trim($_POST['valor']));
    $imagem = mysqli_real_escape_string($conexao, trim($_POST['imagem']));

    $sql = "UPDATE produtos 
            SET nome='$nome', descricao='$descricao', sku='$sku', quantidade='$quantidade', valor='$valor'
            WHERE id='$produto_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        // $_SESSION['mensagem'] = 'Usuário atualizado com sucesso.';
        header('Location: produtos.php');
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi atualizado.';
        header('Location: produtos.php');
        exit;
    }
 }

if (isset($_POST['delete_produto'])) {
	$produto_id = mysqli_real_escape_string($conexao, $_POST['delete_produto']);
	$sql = "DELETE FROM produtos WHERE id = '$produto_id'";
	mysqli_query($conexao, $sql);
	if (mysqli_affected_rows($conexao) > 0) {
		$_SESSION['message'] = 'produto deletado com sucesso';
		header('Location: produtos.php');
		exit;
	} else {
		$_SESSION['message'] = 'produto não foi deletado';
		header('Location: produtos.php');
		exit;
	}
    // Exclua a imagem do servidor
    if (file_exists($produto['imagem'])) {
        unlink($produto['imagem']);
    }

    // Agora, exclua o produto do banco de dados
    $sql = "DELETE FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $produto_id);
    $stmt->execute();

    // Redireciona ou exibe uma mensagem
    header('Location: produtos.php');
}

if (isset($_POST['create_usuarios'])) {
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $nascimento = mysqli_real_escape_string($conexao, trim($_POST['nascimento']));
    $telefone = mysqli_real_escape_string($conexao, trim($_POST['telefone']));

    $sql = "INSERT INTO clientes (nome, cpf, email, nascimento, telefone) VALUES ('$nome', '$cpf', '$email', '$nascimento', '$telefone')";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Usuário criado com sucesso.';
        header('Location: usuarios.php');
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi criado.';
        header('Location: usuarios.php');
        exit;
    }
}

if (isset($_POST['update_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conexao, trim($_POST['usuario_id']));

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $nascimento = mysqli_real_escape_string($conexao, trim($_POST['nascimento']));
    $telefone = mysqli_real_escape_string($conexao, trim($_POST['telefone']));

    $sql = "UPDATE usuarios 
            SET nome='$nome', cpf='$cpf', email='$email', nascimento='$nascimento', telefone='$telefone' 
            WHERE id='$usuario_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Usuário atualizado com sucesso.';
        header('Location: usuarios.php');
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi atualizado.';
        header('Location: usuarios.php');
        exit;
    }
}

if (isset($_POST['delete_usuario'])) {
	$usuario_id = mysqli_real_escape_string($conexao, $_POST['delete_usuario']);
	$sql = "DELETE FROM usuarios WHERE id = '$usuario_id'";
	mysqli_query($conexao, $sql);
	if (mysqli_affected_rows($conexao) > 0) {
		$_SESSION['message'] = 'usuarios deletado com sucesso';
		header('Location: usuarios.php');
		exit;
	} else {
		$_SESSION['message'] = 'usuarios não foi deletado';
		header('Location: usuarios.php');
		exit;
	}
}

?>