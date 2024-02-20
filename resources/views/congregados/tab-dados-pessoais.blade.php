  <div class="tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel" aria-labelledby="border-top-dados-pessoais">
    <blockquote class="blockquote">
    <div class="row mb-4">
      <!-- Coluna para foto do usuário -->
      <div class="col-xl-3 text-center">
        <img src="{{ $pessoa->foto ? asset($pessoa->foto) : 'https://via.placeholder.com/150' }}" id="user-picture" class="rounded-circle img-fluid mb-3" alt="Foto do usuário" width="150px" height="150px;">
        <div>
          <button class="btn btn-primary btn-sm" id="upload-picture">Trocar Foto</button>
          <input type="file" name="foto" class="d-none" id="upload-picture-input">
          <button class="btn btn-danger btn-sm" id="delete-picture">Apagar Foto</button>
        </div>
      </div>
      <!-- Conteúdo do formulário -->
      <div class="col-xl-9">
          <div class="form-group @error('nome') has-error @enderror">
            <div class="row mb-4">
              <div class="col-xl-6">
                <label for="nome">* Nome</label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $pessoa->nome) }}">
                @error('nome')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="col-xl-3">
                <label for="nascimento">* Data de Nascimento</label>
                <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $pessoa->data_nascimento) }}" min="1900-01-01">
                @error('data_nascimento')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-3">
                <label for="sexo">Sexo</label>
                <select class="form-control" id="sexo" name="sexo">
                  <option value="">Selecione</option>
                  <option value="M" {{ $pessoa->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                  <option value="F" {{ $pessoa->sexo == 'F' ? 'selected' : '' }}>Feminino</option>
                </select>
                @error('sexo')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            
            <div class="row mb-4">
    
              <div class="col-xl-3">
                <label for="estado_civil">* Estado Civíl</label>
                <select class="form-control @error('estado_civil') is-invalid @enderror" id="estado_civil" name="estado_civil">
                  <option value="">Selecione</option>
                  <option value="S" {{ $pessoa->estado_civil == 'S' ? 'selected' : '' }}>Solteiro</option>
                  <option value="C" {{ $pessoa->estado_civil == 'C' ? 'selected' : '' }}>Casado</option>
                  <option value="D" {{ $pessoa->estado_civil == 'D' ? 'selected' : '' }}>Divorciado</option>
                  <option value="V" {{ $pessoa->estado_civil == 'V' ? 'selected' : '' }}>Viúvo</option>
                </select>
                @error('estado_civil')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="col-xl-3">
                <label for="nacionalidade">* Nacionalidade</label>
                <select class="form-control @error('estado_civil') is-invalid @enderror" id="nacionalidade" name="nacionalidade">
                  <option value="">Selecione</option>
                  @php
                    //Colocar no banco de dados 
                    $paises = [
                        'BR' => 'Brasil',
                        'US' => 'Estados Unidos',
                        'FR' => 'França',
                        'DE' => 'Alemanha',
                        'IT' => 'Itália',
                        'ES' => 'Espanha',
                        'GB' => 'Reino Unido',
                        'CA' => 'Canadá',
                        'CN' => 'China',
                        'JP' => 'Japão',
                        'RU' => 'Rússia',
                        'IN' => 'Índia',
                        'AU' => 'Austrália',
                        'AR' => 'Argentina',
                        'MX' => 'México',
                        'ZA' => 'África do Sul',
                        'KR' => 'Coreia do Sul',
                        'SE' => 'Suécia',
                        'NL' => 'Holanda',
                        'TR' => 'Turquia',
                    ];

                  @endphp
                  @foreach ($paises as $sigla => $nome)
                    <option value="{{ $sigla }}" {{ old('nacionalidade', $pessoa->nacionalidade) == $sigla ? 'selected' : '' }}>{{ $nome }}</option>
                  @endforeach
                </select>
                @error('nacionalidade')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-3">
                <label for="naturalidade">* Naturalidade</label>
                <input type="text" class="form-control @error('naturalidade') is-invalid @enderror" id="naturalidade" name="naturalidade" value="{{ old('naturalidade', $pessoa->naturalidade) }}" >
                @error('naturalidade')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-3">
                <label for="uf">* UF</label>
                <select class="form-control @error('uf') is-invalid @enderror" id="uf" name="uf">
                  <option value="">Selecione</option>
                  @php
                    //Colocar no banco de dados , esta estranho assim
                    $ufs = [
                      'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas',
                      'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo',
                      'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul',
                      'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
                      'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
                      'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina',
                      'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'
                    ];
                  @endphp
                  @foreach ($ufs as $key => $value)
                    <option value="{{ $key }}" {{ (old('uf', $pessoa->uf) == $key) ? 'selected' : '' }}>{{ $value }}</option>
                  @endforeach
                </select>
                @error('uf')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror                
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col-xl-3">
                <label for="escolaridade_id">Escolaridade</label>
                <select class="form-control" name="escolaridade_id" id="escolaridade_id">
                  <option value="">Selecione</option>
                  @foreach ($formacoes as $formacao)
                      <option value="{{ $formacao->id }}"
                        {{ $formacao->id == old('escolaridade_id', $pessoa->escolaridade_id) ? 'selected' : '' }}>
                        {{ $formacao->descricao }}
                      </option>
                  @endforeach
                </select>
                @error('escolaridade_id')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-3">
                <label for="profissao">Profissão</label>
                <input type="text" class="form-control" id="profissao" name="profissao" value="{{ old('profissao', $pessoa->profissao) }}" >
                @error('profissao')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-6">
                <label for="funcao_eclesiastica_id">Função Eclesiástica</label>
                <select class="form-control" name="funcao_eclesiastica_id" id="funcao_eclesiastica_id">
                  <option value="">Selecione</option>
                  @foreach ($funcoesEclesiasticas as $funcaoEclesiastica)
                      <option value="{{ $funcaoEclesiastica->id }}"
                        {{ $funcaoEclesiastica->id == old('funcao_eclesiastica_id', $pessoa->funcao_eclesiastica_id) ? 'selected' : '' }}>
                        {{ $funcaoEclesiastica->descricao }}
                      </option>
                  @endforeach
                </select>
                @error('funcao_eclesiastica_id')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <div class="row mb-4">
              <div class="col-xl-3">
                <label for="cpf">* CPF</label>
                <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf" value="{{ old('cpf', $pessoa->cpf) }}">
                @error('cpf')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-3">
                <label for="tipo_documento">Tipo Documento</label>
                <select class="form-control" name="tipo_documento" id="tipo_documento">
                  <option value="">Selecione</option>
                  <option value="RG">RG</option>
                  <option value="CNH">CNH</option>    
                </select>
                @error('tipo_documento')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-3">
                <label for="documento">Documento</label>
                <input type="text" class="form-control" id="documento" name="documento" value="{{ old('documento', $pessoa->documento) }}">
                @error('documento')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-3">
                <label for="documento_complemento">Complemento Documento</label>
                <input type="text" class="form-control" id="documento_complemento" name="documento_complemento" value="{{ old('documento_complemento', $pessoa->documento_complemento) }}">
                @error('documento_complemento')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-xl-4">
                <label for="data_conversao">Data de Conversão</label>
                <input type="date" class="form-control @error('data_conversao') is-invalid @enderror" id="data_conversao" name="data_conversao" value="{{ old('data_conversao', $pessoa->data_conversao) }}">
                @error('data_conversao')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-4">
                <label for="data_batismo">Data de Batismo</label>
                <input type="date" class="form-control @error('data_batismo') is-invalid @enderror" id="data_batismo" name="data_batismo" value="{{ old('data_batismo', $pessoa->data_batismo) }}">
                @error('data_batismo')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xl-4">
                <label for="data_batismo_espirito">Data de Batismo Espirito Santo</label>
                <input type="date" class="form-control @error('data_batismo_espirito') is-invalid @enderror" id="data_batismo_espirito" name="data_batismo_espirito" value="{{ old('data_batismo_espirito', $pessoa->data_batismo_espirito) }}">
                @error('data_batismo_espirito')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-xl-12">
                <label for="historico">Pastor Oficiante</label>
                <input type="text" class="form-control" id="historico" name="historico" value="{{ old('historico', $pessoa->historico) }}">
                @error('historico')
                  <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>            
            </div>
          </div>                       
      </div>
    </div>
  </blockquote>
  </div>