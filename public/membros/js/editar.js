$(document).ready(function(){
    // Função para adicionar uma nova formação
        function adicionarLinhaFormacao() {
            var novaLinha = `
            <tr>
                <td>
                    <select class="form-control curso-nome" name="curso-nome[]">
                        <option value="">Selecione um curso</option>
                        <option value="curso">Curso Teste</option>
                        <option value="cursodois">Curso Teste Dois</option>
                    </select>
                </td>
                <td>
                    <input type="date" class="form-control" name="curso-data-inicio[]">
                </td>
                <td>
                    <input type="date" class="form-control" name="curso-data-conclusao[]">
                </td>
                <td>
                    <input type="text" class="form-control" name="curso-observacao[]">
                </td>
                <td style="width: 100px;">
                    <button type="button" class="btn btn-sm btn-secondary mr-2 btn-rounded apagar-linha-formacao">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </button>
                </td>
            </tr>
            `;

            // Adiciona a nova linha à tabela
            $('#formacao-tbody').append(novaLinha);
        }

        // Adiciona uma nova linha ao carregar a página
        adicionarLinhaFormacao();

        // Adicionar nova linha quando interagir com o último select de curso
        $('#formacao-tbody').on('change', '.curso-nome:last', function() {
            adicionarLinhaFormacao();
        });

        // Adiciona evento para apagar linha com confirmação
        $('body').on('click', '.apagar-linha-formacao', function(){
            // Confirmação antes de apagar
            if(confirm("Deseja apagar esta linha?")) {
                // Verifica se é a única linha, para garantir que sempre exista pelo menos uma
                if($('#formacao-tbody tr').length > 1) {
                    $(this).closest('tr').remove(); // Remove a linha mais próxima (a linha do botão clicado)
                    toastr.success("Linha apagada com sucesso.");
                } else {
                    toastr.error("Não é possível apagar a única linha restante.");
                }
            }
        });

    // Função para adicionar um novo Ministerial
        function adicionarLinhaMinisterial() {
            var novaLinha = `
            <tr>
                <td>
                    <select class="form-control ministerial-departamento" name="ministerial-departamento[]">
                        <option value="">Selecione</option>
                        <option value="dep1">Departamento Teste</option>
                        <option value="dep2">Departamento Teste Dois</option>
                    </select>
                </td>
                <td>
                    <select class="form-control" name="ministerial-funcao[]">
                        <option value="">Selecione</option>
                        <option value="fun1">Função Teste</option>
                        <option value="fun2">Função Teste Dois</option>
                    </select>
                </td>
                <td>
                    <input type="date" class="form-control" name="ministerial-nomeacao[]">
                </td>
                <td>
                    <input type="date" class="form-control" name="ministerial-exoneracao[]">
                </td>
                <td>
                    <input type="text" class="form-control" name="ministerial-observacao[]">
                </td>
                <td style="width: 100px;">
                    <button type="button" class="btn btn-sm btn-secondary mr-2 btn-rounded apagar-linha-ministerial">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </button>
                </td>
            </tr>
            `;

            // Adiciona a nova linha à tabela
            $('#ministerial-tbody').append(novaLinha);
        }
        // Adiciona uma nova linha ao carregar a página
        adicionarLinhaMinisterial();

        // Adicionar nova linha quando interagir com o último select de curso
        $('#ministerial-tbody').on('change', '.ministerial-departamento:last', function() {
            adicionarLinhaMinisterial();
        });
        // Adiciona evento para apagar linha com confirmação
        $('body').on('click', '.apagar-linha-ministerial', function(){
            // Confirmação antes de apagar
            if(confirm("Deseja apagar esta linha?")) {
                // Verifica se é a única linha, para garantir que sempre exista pelo menos uma
                if($('#ministerial-tbody tr').length > 1) {
                    $(this).closest('tr').remove(); // Remove a linha mais próxima (a linha do botão clicado)
                    toastr.success("Linha apagada com sucesso.");
                } else {
                    toastr.error("Não é possível apagar a única linha restante.");
                }
            }
        });



});
