  <div class="tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel" aria-labelledby="border-top-dados-pessoais">
    <blockquote class="blockquote">
    <div class="row mb-4">
      <!-- Coluna para foto do usuário -->
      <div class="col-xl-3 text-center">
        <img src="https://via.placeholder.com/150" id="user-picture" class="rounded-circle img-fluid mb-3" alt="Foto do usuário">
        <div>
          <button class="btn btn-primary btn-sm" id="upload-picture">Trocar Foto</button>
          <input type="file" class="d-none" id="upload-picture-input">
          <button class="btn btn-danger btn-sm" id="delete-picture">Apagar Foto</button>
        </div>
      </div>
      <!-- Conteúdo do formulário -->
      <div class="col-xl-9">
          <div class="form-group @error('nome') has-error @enderror">
            <div class="row mb-4">
              <div class="col-xl-6">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $pessoa->nome) }}">
                @error('nome')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="col-xl-3">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="{{ old('cpf', $pessoa->cpf) }}">
                @error('cpf')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="col-xl-3">
                <label for="nascimento">Dia de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $pessoa->data_nascimento) }}" min="1900-01-01">
                @error('nascimento')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            
            <div class="row mb-4">
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
    
              <div class="col-xl-3">
                <label for="estado_civil">Estado Civíl</label>
                <select class="form-control" id="estado_civil" name="estado_civil">
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
                <label for="nacionalidade">Nacionalidade</label>
                <select class="form-control" id="nacionalidade" name="nacionalidade">
                  @php
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
                <label for="uf">UF</label>
                <select class="form-control" id="uf" name="uf">
                  @php
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
              <{{-- div class="col-xl-3">
                <label for="rol">No. Rol</label>
                <input type="number" class="form-control" id="rol" name="rol" value="{{ old('rol') }}">
                @error('rol')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div> --}}
    
              <div class="col-xl-3">
                <label for="data_conversao">Data de Conversão</label>
                <input type="date" class="form-control" id="data_conversao" name="data_conversao" value="{{ old('data_conversao', $pessoa->data_conversao) }}">
                @error('data_conversao')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-xl-12">
                <label for="historico">Histórico</label>
                <textarea class="form-control" aria-label="With textarea" id="historico" name="historico" style="resize: none; overflow: auto;">{{ old('historico', $pessoa->historico) }}</textarea>
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