$(document).ready(function () {
    //Mascaras
        $('#telefone-preferencial, #telefone-alternativo, #telefone-whatsapp').mask('(00) 00000-0000');
        $('#cpf').mask('000.000.000-00');
        $('#cep').mask('00000-000');
    // Função para adicionar linha
    $('body').on('click', '.adicionar-linha-ministerial', function () {
        var novaLinha = $('#ministerial-tbody tr:last').clone();
        novaLinha.find('input').val(''); // Limpa os valores dos inputs
        novaLinha.find('select').prop('selectedIndex', 0); // Reseta os selects
        $('#ministerial-tbody').append(novaLinha);
        atualizarBotoes();
    });

    // Função para remover linha com confirmação
    $('body').on('click', '.apagar-linha-ministerial', function () {
        if ($('#ministerial-tbody tr').length > 1) {
            // Exibe a caixa de diálogo de confirmação
            var confirma = confirm("Tem certeza que deseja remover esta linha?");
            if (confirma) {
                // Se o usuário confirmar, remove a linha
                $(this).closest('tr').remove();
                atualizarBotoes();
            }
        } else {
            // Opcional: exibir uma mensagem informando que não é possível remover a última linha
            alert("Não é possível remover a última linha.");
        }
    });

    // Função para atualizar a visibilidade dos botões
    function atualizarBotoes() {
        $('.adicionar-linha-ministerial, .apagar-linha-ministerial').hide(); // Esconde todos os botões
        $('#ministerial-tbody tr:last .adicionar-linha-ministerial').show(); // Mostra botão adicionar apenas na última linha
        if ($('#ministerial-tbody tr').length > 1) {
            $('.apagar-linha-ministerial').show(); // Mostra todos os botões apagar quando há mais de uma linha
        }
    }

    atualizarBotoes(); // Chama a função no carregamento da página
});