<div class="tab-pane fade" id="border-top-disciplina" role="tabpanel" aria-labelledby="border-top-disciplina">
    <blockquote class="blockquote">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mb-4">
                <thead>
                    <tr>
                        <th>DATA INICIO</th>
                        <th>DATA TERMINO</th>
                        <th>IGREJA</th>
                        <th>PASTOR</th>
                        <th>REGIAO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="disciplina-tbody">
                    @foreach ($disciplinas as $disciplina)
                        <tr id="tr_disciplina_{{ $disciplina->id }}">
                            <td>{{ $disciplina->dt_inicio->format('d/m/Y') }}</td>
                            <td class="td_dt_termino">
                                @if ($disciplina->dt_termino)
                                    {{ $disciplina->dt_termino->format('d/m/Y') }}
                                @else
                                    <input class="form-control dt_termino_input" type="date" />
                                @endif
                            </td>
                            <td>{{ $igreja }}</td>
                            <td>{{ optional($disciplina->pastor)->nome }}</td>
                            <td>{{ optional($disciplina->regiao)->nome }}</td>
                            @if ($disciplina->dt_termino == null)
                                <td class="td_btn_encerrar">
                                    <button type="button" class="btn btn-warning dt_termino_button" onclick="encerrarDisciplina(event, {{ $disciplina->id }})">
                                        <x-bx-block /> Encerrar Disciplina
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </blockquote>
</div>




@push('tab-scripts')
<script>
    function encerrarDisciplina(event, id) {
        event.preventDefault();

        // pegar a data de término da disciplina
        const tr = document.getElementById(`tr_disciplina_${id}`)
        const tdDtTermino = tr.querySelector('.td_dt_termino');
        const { value: dt_termino } = tr.querySelector('.dt_termino_input');
        const button = tr.querySelector('.dt_termino_button');
        const buttonContent = button.innerHTML

        if(!dt_termino) {
            toastr.warning('Você precisa informar uma data de término!')
            return
        }

        $.ajax({
            url: `/membro/disciplinar/update/${id}`,
            method: "PUT",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { dt_termino },
            beforeSend: function () {
                button.innerHTML = `<div class="spinner-border mr-2 text-white align-self-center loader-sm "></div>Carregando...`
                button.setAttribute('disabled', true);
            },
            success: function (response) {
                tdDtTermino.innerHTML = moment(dt_termino, 'YYYY-MM-DD').format('DD/MM/YYYY')

                button.remove();
                toastr.success('Disciplina finalizada com sucessso!');
            },
            error: function (error) {
                // Lógica de erro, se necessário
                toast.error('Erro ao finalizar a disciplina');
                button.innerHTML = buttonContent;
            }
        });     
    }
</script>
@endpush