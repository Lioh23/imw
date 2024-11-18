<div class="tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel" aria-labelledby="border-top-dados-pessoais">
    <blockquote class="blockquote">
        <!-- Conteúdo do formulário -->
        <div class="col-12">
            <div class="form-group @error('nome') has-error @enderror">
                <div class="row mb-4">
                    <div class="col-xl-5">
                        <label for="nome">* Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" maxlength="100">
                        @error('nome')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-xl-3">
                        <label for="cpf">* CPF</label>
                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf" value="{{ old('cpf') }}" maxlength="100">
                        @error('cpf')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-xl-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xl-3">
                        <label for="categoria">* Categoaria</label>
                        <select class="form-control" type="text" id="categoria" name="categoria">
                            <option value="missionaria" {{ old('categoria') == 'missionaria' ? 'selected' : '' }}>Missionária</option>
                            <option value="pastor" {{ old('categoria') == 'pastor' ? 'selected' : '' }}>Pastor</option>
                            <option value="ministro" {{ old('categoria') == 'ministro' ? 'selected' : '' }}>Ministro</option>
                            <option value="bispo" {{ old('categoria') == 'bispo' ? 'selected' : '' }}>Bispo</option>
                        </select>
                        @error('categoria')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-xl-3">
                        <label for="sexo">Sexo</label>
                        <select class="form-control" id="sexo" name="sexo">
                            <option value="">Selecione</option>
                            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                        </select>
                        @error('sexo')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-xl-3">
                        <label for="estado_civil">* Estado Civil</label>
                        <select class="form-control @error('estado_civil') is-invalid @enderror" id="estado_civil" name="estado_civil">
                            <option value="">Selecione</option>
                            <option value="S" {{ old('estado_civil') == 'S' ? 'selected' : '' }}>Solteiro</option>
                            <option value="C" {{ old('estado_civil') == 'C' ? 'selected' : '' }}>Casado</option>
                            <option value="D" {{ old('estado_civil') == 'D' ? 'selected' : '' }}>Divorciado</option>
                            <option value="V" {{ old('estado_civil') == 'V' ? 'selected' : '' }}>Viúvo</option>
                        </select>
                        @error('estado_civil')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-xl-3">
                        <label for="formacao_id">Formação</label>
                        <select class="form-control" name="formacao_id" id="formacao_id">
                            <option value="">Selecione</option>
                            @foreach ($formacoes as $formacao)
                                <option value="{{ $formacao->id }}" {{ old('formacao_id') == $formacao->id ? 'selected' : '' }}>{{ $formacao->nivel }}</option>
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
                        <input type="text" class="form-control" id="nome_mae" name="nome_mae" value="{{ old('nome_mae') }}">
                    </div>
                    <div class="col-12 mt-3 col-md-4">
                        <label for="nome_pai">Nome do Pai</label>
                        <input type="text" class="form-control" id="nome_pai" name="nome_pai" value="{{ old('nome_pai') }}">
                    </div>
                </div>
            </div>
        </div>
    </blockquote>
</div>
