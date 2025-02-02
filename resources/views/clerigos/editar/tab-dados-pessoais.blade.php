<div class="tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel"
    aria-labelledby="border-top-dados-pessoais">
    <blockquote class="blockquote">


        <!-- Conteúdo do formulário -->
        <div class="col-12">
            <div class="form-group @error('nome') has-error @enderror">
                <input type="hidden" id="regiao_id" value="23">
                <div class="row mb-4">
                    <div class="col-xl-5">
                        <label for="nome">* Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome"
                            name="nome" value="{{ old('nome', $clerigo->nome) }}" maxlength="100">
                        @error('nome')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{--

                    <div class="col-xl-3">
                        <label for="nascimento">* Data de Nascimento</label>
                        <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror"
                            id="data_nascimento" name="data_nascimento"
                            value="{{ old('data_nascimento', optional($clerigo->data_nascimento)->format('Y-m-d')) }}">
                        @error('data_nascimento')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <div class="col-xl-3">
                        <label for="cpf">* CPF</label>
                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf"
                            name="cpf" value="{{ old('cpf', $clerigo->cpf) }}" maxlength="18">
                        @error('cpf')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-xl-4">
                        <label for="email ">Email</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $clerigo->email) }}" maxlength="255">
                    </div>
                    @error('email')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror

                </div>
                <div class="row mb-4">
                    <div class="col-xl-3">
                        <label for="categoria">* Categoria</label>
                        <select class="form-control  @error('categoria') is-invalid @enderror" type="text"
                            id="categoria" name="categoria">
                            <option value="missionária" {{ $clerigo->categoria == 'missionária' ? 'selected' : '' }}>
                                Missionária</option>
                            <option value="pastor" {{ $clerigo->categoria == 'pastor' ? 'selected' : '' }}>Pastor
                            </option>
                            <option value="ministro" {{ $clerigo->categoria == 'ministro' ? 'selected' : '' }}>
                                Ministro</option>
                            <option value="bispo" {{ $clerigo->categoria == 'bispo' ? 'selected' : '' }}>Bispo
                            </option>
                        </select>
                        @error('categoria')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-xl-3">
                        <label for="sexo">Sexo</label>
                        <select class="form-control" id="sexo" name="sexo">
                            <option value="">Selecione</option>
                            <option value="M" {{ $clerigo->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ $clerigo->sexo == 'F' ? 'selected' : '' }}>Feminino</option>
                        </select>
                        @error('sexo')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-xl-3">
                        <label for="estado_civil">* Estado Civíl</label>
                        <select class="form-control @error('estado_civil') is-invalid @enderror" id="estado_civil"
                            name="estado_civil">
                            <option value="">Selecione</option>
                            <option value="S" {{ $clerigo->estado_civil == 'S' ? 'selected' : '' }}>Solteiro
                            </option>
                            <option value="C" {{ $clerigo->estado_civil == 'C' ? 'selected' : '' }}>Casado
                            </option>
                            <option value="D" {{ $clerigo->estado_civil == 'D' ? 'selected' : '' }}>Divorciado
                            </option>
                            <option value="V" {{ $clerigo->estado_civil == 'V' ? 'selected' : '' }}>Viúvo
                            </option>
                        </select>
                        @error('estado_civil')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-xl-3">
                        <label for="formacao_id">* Formação</label>
                        <select class="form-control @error('formacao_id') is-invalid @enderror" name="formacao_id"
                            id="formacao_id">
                            <option value="">Selecione</option>
                            @foreach ($formacoes as $formacao)
                                <option value="{{ $formacao->id }}"
                                    {{old('formacao_id', $clerigo->formacao_id) == $formacao->id ? 'selected' : '' }}>
                                    {{ $formacao->nivel }}
                                </option>
                            @endforeach
                        </select>
                        @error('formacao_id')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="row mb-4">
                    <div class="col-12 mt-3 col-md-4">
                        <label for="nome_mae">Nome da Mãe</label>
                        <input type="text" class="form-control" id="nome_mae" name="nome_mae"
                            value="{{ old('nome_mae', $clerigo->nome_mae) }}" maxlength="50">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="nome_pai">Nome do Pai</label>
                        <input type="text" class="form-control" id="nome_pai" name="nome_pai"
                            value="{{ old('nome_pai', $clerigo->nome_pai) }}" maxlength="50">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="data_nascimento">Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
                            value="{{ old('data_nascimento', $clerigo->data_nascimento) }}">
                    </div>
                </div>
            </div>

    </blockquote>
</div>

@push('tab-scripts')
@endpush
