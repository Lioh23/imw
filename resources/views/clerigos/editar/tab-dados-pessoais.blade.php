<style>
.input_container {
  border: 1px solid #4361ee;
  cursor: pointer;
  border-radius: 5px;
  font-size: 14px;
}

input[type=file]::file-selector-button {
  background-color: #fff;
  color: #000;
  border: 0px;
  border-right: 1px solid #e5e5e5;
  padding: 10px 15px;
  margin-right: 20px;
  transition: .5s;
  cursor: pointer;
}

input[type=file]::file-selector-button:hover {
  background-color: #eee;
  border: 0px;
  border-right: 1px solid #e5e5e5;
  cursor: pointer;
}
</style>
<div class="tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel"
    aria-labelledby="border-top-dados-pessoais">
    <blockquote class="blockquote">
        <div class="row mb-4">
            <!-- Coluna para foto do usuário -->
            <div class="col-xl-3 text-center">
                <input type="hidden" name="membro_id" value="{{ $clerigo->id }}">
                <!-- <img src="{{ $clerigo->foto ? asset($clerigo->foto) : 'https://palmtecnologia.com.br/wp-content/uploads/2023/07/sem-foto.jpg' }}" id="user-picture" class="rounded-circle img-fluid mb-3" alt="Foto do usuário" width="150px" height="150px;"> -->
                <div>
                    <!-- <button class="btn btn-primary btn-sm" id="upload-picture">Trocar Foto</button>
                    <input type="file" name="foto" class="d-none" id="upload-picture-input">
                    <button class="btn btn-danger btn-sm" id="delete-picture">Apagar Foto</button> -->

                    <div class="col-md-12"> 
                        <img id="showImage" src="{{ url('theme/images/sem-foto.jpg')}}" alt="Admin" width="150" height="150"> 
                    </div>
                    <div class="form-group col-md-12" style="margin-top: 10px;">
                        <label for="image" class="form-label"><b>Upload de foto</b> (.png|.jpg|.jpeg|.webp)</label>
                        <div class="input_container">
                            <input name="image" type="file" id="image">
                        </div>
                    </div>

                </div>
            </div>
            <!-- Conteúdo do formulário -->
            <div class="col-xl-9">
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
                                <option value="">Selecione</option>
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
                                        {{ old('formacao_id', $clerigo->formacao_id) == $formacao->id ? 'selected' : '' }}>
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
                            <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror"
                                id="data_nascimento" name="data_nascimento"
                                value="{{ old('data_nascimento', $clerigo->data_nascimento) }}">
                            @error('data_nascimento')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 mt-3 col-md-3">
                            <label for="data_consagracao">* Data de Consagração</label>
                            <input type="date" class="form-control @error('data_consagracao') is-invalid @enderror"
                                id="data_consagracao" name="data_consagracao"
                                value="{{ old('data_consagracao', $clerigo->data_consagracao) }}">
                            @error('data_consagracao')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mt-3 col-md-3">
                            <label for="data_ordenacao">Data de Ordenação</label>
                            <input type="date" class="form-control @error('data_ordenacao') is-invalid @enderror"
                                id="data_ordenacao" name="data_ordenacao"
                                value="{{ old('data_ordenacao', $clerigo->data_ordenacao) }}">
                            @error('data_ordenacao')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mt-3 col-md-3">
                            <label for="data_integralização">Data de Integralização</label>
                            <input type="date" class="form-control @error('data_integralização') is-invalid @enderror"
                                id="data_integralização" name="data_integralização"
                                value="{{ old('data_integralização', $clerigo->data_integralização) }}">
                            @error('data_integralização')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mt-3 col-md-3">
                            <label for="rol">* Rol</label>
                            <input type="text" class="form-control" id="rol" name="rol"
                                value="{{ old('rol', $clerigo->rol) }}" maxlength="50">
                        </div>
                    </div>
                </div>
            </div>

    </blockquote>
</div>

@push('tab-scripts')
@endpush
