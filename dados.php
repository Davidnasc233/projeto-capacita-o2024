<?php
function validate_credentials($username, $password) {
    // Caminho para o arquivo de usuários
    $file = 'dados.txt';
    
    // Verifica se o arquivo existe
    if (!file_exists($file)) {
        die('Arquivo de usuários não encontrado.');
    }

    // Abre o arquivo e lê linha por linha
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // Percorre cada linha do arquivo
    foreach ($lines as $line) {
        // Separa a linha em usuário e senha
        list($stored_username, $stored_password) = explode(':', trim($line));

        // Verifica se as credenciais correspondem
        if ($username === $stored_username && $password === $stored_password) {
            return true;
        }
    }
    return false;
}

?>



