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
                <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}">
                @error('nome')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="col-xl-3">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="{{ old('cpf') }}">
                @error('cpf')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="col-xl-3">
                <label for="nascimento">Dia de Nascimento</label>
                <input type="date" class="form-control" id="nascimento" name="nascimento" value="{{ old('nascimento') }}" min="1900-01-01">
                @error('nascimento')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col-xl-3">
                <label for="sexo">Sexo</label>
                <select class="form-control" id="sexo" name="sexo">
                  <option value="M">Masculino</option>
                  <option value="F">Feminino</option>
                </select>
                @error('sexo')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="col-xl-3">
                <label for="estado-civil">Estado Civíl</label>
                <select class="form-control" id="estado-civil" name="estado-civil">
                  <option value="S">Solteiro</option>
                  <option value="C">Casado</option>
                  <option value="D">Divorciado</option>
                  <option value="V">Viúvo</option>
                </select>
                @error('estado-civil')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="col-xl-3">
                <label for="nacionalidade">Nacionalidade</label>
                <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" value="{{ old('nacionalidade') }}">
                @error('nacionalidade')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="col-xl-3">
                <label for="uf">UF</label>
                <select class="form-control" id="uf" name="uf">
                  <option value="AC">Acre</option>
                  <option value="AL">Alagoas</option>
                  <option value="AP">Amapá</option>
                  <option value="AM">Amazonas</option>
                  <option value="BA">Bahia</option>
                  <option value="CE">Ceará</option>
                  <option value="DF">Distrito Federal</option>
                  <option value="ES">Espírito Santo</option>
                  <option value="GO">Goiás</option>
                  <option value="MA">Maranhão</option>
                  <option value="MT">Mato Grosso</option>
                  <option value="MS">Mato Grosso do Sul</option>
                  <option value="MG">Minas Gerais</option>
                  <option value="PA">Pará</option>
                  <option value="PB">Paraíba</option>
                  <option value="PR">Paraná</option>
                  <option value="PE">Pernambuco</option>
                  <option value="PI">Piauí</option>
                  <option value="RJ">Rio de Janeiro</option>
                  <option value="RN">Rio Grande do Norte</option>
                  <option value="RS">Rio Grande do Sul</option>
                  <option value="RO">Rondônia</option>
                  <option value="RR">Roraima</option>
                  <option value="SC">Santa Catarina</option>
                  <option value="SP">São Paulo</option>
                  <option value="SE">Sergipe</option>
                  <option value="TO">Tocantins</option>
                </select>
                @error('uf')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col-xl-3">
                <label for="rol">No. Rol</label>
                <input type="number" class="form-control" id="rol" name="rol" value="{{ old('rol') }}">
                @error('rol')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="col-xl-3">
                <label for="data-conversao">Data de Conversão</label>
                <input type="date" class="form-control" id="data-conversao" name="data-conversao" value="{{ old('data-conversao') }}">
                @error('data-conversao')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-xl-12">
                <label for="history">Histórico</label>
                <textarea class="form-control" aria-label="With textarea" id="history" name="history" value="{{ old('history') }}" style="resize: none; overflow: auto;"></textarea>
                @error('history')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>                       
      </div>
    </div>
  </blockquote>  
  </div>