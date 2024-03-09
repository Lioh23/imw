<div class="tab-pane fade" id="border-top-disciplina" role="tabpanel" aria-labelledby="border-top-disciplina">
    <blockquote class="blockquote">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mb-4">
                <thead>
                    <tr>
                        <th>DATA INICIO</th>
                        <th>DATA TERMINO</th>
                        <th>MODO/FORMA</th>
                        <th>OBSERVACAO</th>
                        <th>IGREJA</th>
                        <th>CONGREGAÇÃO</th>
                        <th>PASTOR</th>
                        <th>REGIAO</th>
                    </tr>
                </thead>
                <tbody id="disciplina-tbody">
                    @foreach ($disciplinas as $disciplina)
                        @foreach ($pessoa->rolPermanente as $rolPermanente)
                            <tr>
                                <td>{{ $disciplina->dt_inicio }}</td>
                                @if ($disciplina->dt_termino != null)
                                    <td>{{ $disciplina->dt_termino }}</td>
                                @else
                                    <td><input type="date" name="dt_termino" id="dt_termino" /></td>
                                @endif
                                <td>{{ $disciplina->modo_disciplina_id }}</td>
                                <td>{{ $disciplina->observacao }}</td>
                                <td>{{ $igreja }}</td>
                                <td>{{ $rolPermanente->congregacao->nome }}</td>
                                <td>{{ $rolPermanente->clerigo->nome }}</td>
                                <td>{{ $regiao }}</td>
                                @if ($disciplina->dt_termino == null)
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-warning"
                                            onclick="encerrarDisciplina({{ $disciplina->id }})">
                                            <x-bx-block /> Encerrar Disciplina
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
                @push('scripts')
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script>
                        function encerrarDisciplina(disciplinaId) {
                            var dtTermino = document.getElementById('dt_termino_' + disciplinaId).value;
                
                            // Enviar dados usando Ajax
                            $.ajax({
                                url: "{{ route('disciplinar_encerrar', ['id' => '']) }}/" + disciplinaId,
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}", // Adicione o token CSRF para proteger contra CSRF
                                    dt_termino: dtTermino
                                },
                                success: function (response) {
                                    // Lógica de sucesso, se necessário
                                    console.log(response);
                                },
                                error: function (error) {
                                    // Lógica de erro, se necessário
                                    console.error(error);
                                }
                            });
                        }
                    </script>
                @endpush
            </table>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('membro.exclusao_transferencia', ['id' => $pessoa->id]) }}"
                    class="btn btn-secondary">
                    <x-bx-transfer-alt /> Transferir
                </a>
                <a href="{{ route('membro.disciplinar', ['id' => $pessoa->id]) }}" class="btn btn-warning">
                    <x-bx-block /> Disciplinar
                </a>
                <a href="{{ route('membro.exclusao', ['id' => $pessoa->id]) }}" class="btn btn-danger">
                    <x-bx-minus-circle /> Excluir
                </a>
                <a href="{{ route('membro.transferencia_interna', ['id' => $pessoa->id]) }}" class="btn btn-primary">
                    <x-bx-transfer-alt /> Transferir Internamente
                </a>
            </div>
        </div>
    </blockquote>
</div>
