$(document).ready(function () {
    // Máscaras
    $('#telefone-preferencial, #telefone-alternativo, #telefone-whatsapp').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#cep').mask('00000-000');

    // Adicionar e remover linhas na tabela de Ministério
    // Função para adicionar linha de ministério
    $('body').on('click', '.adicionar-linha-ministerial', function () {
        var novaLinha = $('#ministerial-tbody tr:last').clone();
        novaLinha.find('input').val('');
        novaLinha.find('select').prop('selectedIndex', 0);
        $('#ministerial-tbody').append(novaLinha);
        atualizarBotoesMinisterial();
    });

    // Função para remover linha de ministério com confirmação
    $('body').on('click', '.apagar-linha-ministerial', function () {
        if ($('#ministerial-tbody tr').length > 1) {
            var confirma = confirm("Tem certeza que deseja remover esta linha?");
            if (confirma) {
                $(this).closest('tr').remove();
                atualizarBotoesMinisterial();
            }
        } else {
            alert("Não é possível remover a última linha.");
        }
    });

    // Adicionar e remover linhas na tabela de Formação Eclesiástica
    // Função para adicionar linha de formação
    $('body').on('click', '.adicionar-formacaoEclesiastica', function () {
        var novaLinha = $('#formacao-tbody tr:last').clone();
        novaLinha.find('input').val('');
        novaLinha.find('select').prop('selectedIndex', 0);
        $('#formacao-tbody').append(novaLinha);
        atualizarBotoesFormacao();
    });

    // Função para remover linha de formação com confirmação
    $('body').on('click', '.apagar-linha-formacaoEclesiastica', function () {
        if ($('#formacao-tbody tr').length > 1) {
            var confirma = confirm("Tem certeza que deseja remover esta linha?");
            if (confirma) {
                $(this).closest('tr').remove();
                atualizarBotoesFormacao();
            }
        } else {
            alert("Não é possível remover a última linha.");
        }
    });

    // Função para atualizar a visibilidade dos botões de ministério
    function atualizarBotoesMinisterial() {
        $('.adicionar-linha-ministerial, .apagar-linha-ministerial').hide();
        $('#ministerial-tbody tr:last .adicionar-linha-ministerial').show();
        if ($('#ministerial-tbody tr').length > 1) {
            $('.apagar-linha-ministerial').show();
        }
    }

    // Função para atualizar a visibilidade dos botões de formação
    function atualizarBotoesFormacao() {
        $('.adicionar-formacaoEclesiastica, .apagar-linha-formacaoEclesiastica').hide();
        $('#formacao-tbody tr:last .adicionar-formacaoEclesiastica').show();
        if ($('#formacao-tbody tr').length > 1) {
            $('.apagar-linha-formacaoEclesiastica').show();
        }
    }

    // Inicializar visibilidade dos botões
    atualizarBotoesMinisterial();
    atualizarBotoesFormacao();
});
