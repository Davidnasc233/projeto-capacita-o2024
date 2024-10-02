 // Garante que o DOM foi completamente carregado antes de executar o script
 document.addEventListener("DOMContentLoaded", function() {
    const removeProductButtons = document.getElementsByClassName("bt-remover");
    console.log(removeProductButtons); // Verifica se os botões foram capturados

    // Adiciona o event listener a cada botão
    for (var i = 0; i < removeProductButtons.length; i++) {
        removeProductButtons[i].addEventListener("click", function(event) {
            console.log("clicou");
            // Encontra a linha (tr) correspondente ao botão clicado e remove ela
            const row = event.target.closest("tr");
            if (row) {
                row.remove(); // Remove a linha inteira da tabela
                updateTotal()
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const addProductButtons = document.getElementsByClassName("bt-add-produto");

    // Adiciona o event listener a cada botão
    for (var i = 0; i < addProductButtons.length; i++) {
        addProductButtons[i].addEventListener("click", function(event) {
            console.log("clicou");
            
            // Pega a tabela onde os produtos serão adicionados
            const table = document.querySelector("table tbody");

            // Cria uma nova linha (tr)
            const newRow = document.createElement("tr");

            // Adiciona células (td) à nova linha
            newRow.innerHTML = `
                <td><input type="text" class="input" name="produto"></td>
                <td><input type="number" class="input quantidade" name="quantidade"></td>
                <td><input type="text" class="input valorParcial" name="valorParcial"></td>
                <td><a href="#" class="bt-remover"><img src="assets/images/remover.svg" alt="Remover" /></a></td>
            `;

            // Adiciona a nova linha à tabela
            table.appendChild(newRow);

            // Opcional: você pode adicionar o event listener para o botão de remover diretamente aqui
            const removeButton = newRow.querySelector(".bt-remover");
            removeButton.addEventListener("click", function() {
                newRow.remove();
            });
        });
    }
});

document.getElementById('buscaCliente').addEventListener('click', function() {
    const query = document.getElementById('buscaCliente').value;

    // Faz a requisição AJAX via fetch para o servidor PHP
    fetch('acoe-crud.php?q=' + query)
        .then(response => response.json()) // Espera um JSON como resposta
        .then(data => {
            let resultsDiv = document.getElementById('buscaCliente');
            resultsDiv.innerHTML = ''; // Limpa os resultados anteriores
            
            if (data.length > 0) {
                // Itera sobre os resultados e exibe na página
                data.forEach(cliente => {
                    let p = document.createElement('p');
                    p.textContent = cliente.nome;
                    resultsDiv.appendChild(p);
                });
            } else {
                resultsDiv.textContent = 'Nenhum cliente encontrado';
            }
        })
        .catch(error => console.error('Erro na busca:', error));
});
