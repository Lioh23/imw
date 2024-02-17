  <div class="tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel" aria-labelledby="border-top-dados-pessoais">
    <blockquote class="blockquote">
    <div class="row mb-4">
      <!-- Coluna para foto do usuário -->
      <div class="col-xl-3 text-center">
        <img src="https://via.placeholder.com/150" class="rounded-circle img-fluid mb-3" alt="Foto do usuário">
        <div>
          <button class="btn btn-primary btn-sm">Trocar Foto</button>
          <button class="btn btn-danger btn-sm">Apagar Foto</button>
        </div>
      </div>
      <!-- Conteúdo do formulário -->
      <div class="col-xl-9">
          <div class="form-group @error('nome') has-error @enderror">
            <div class="row mb-4">
              <div class="col-xl-6">
                <label for="nome">* Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
                @error('nome')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="col-xl-3">
                <label for="cpf">* CPF</label>
                <input type="number" class="form-control" id="cpf" name="cpf" value="{{ old('cpf') }}" required>
                @error('cpf')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="col-xl-3">
                <label for="nascimento">* Dia de Nascimento</label>
                <input type="date" class="form-control" id="nascimento" name="nascimento" value="{{ old('nascimento') }}" required>
                @error('nascimento')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col-xl-3">
                <label for="sexo">* Sexo</label>
                <select class="form-control" id="sexo" name="sexo" required>
                  <option value="M">Masculino</option>
                  <option value="F">Feminino</option>
                </select>
                @error('sexo')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="col-xl-3">
                <label for="estado-civil">* Estado Civíl</label>
                <select class="form-control" id="estado-civil" name="estado-civil" required>
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
                <label for="nacionalidade">* Nacionalidade</label>
                <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" value="{{ old('nacionalidade') }}" required>
                @error('nacionalidade')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
    
              <div class="col-xl-3">
                <label for="uf">* UF</label>
                <select class="form-control" id="uf" name="uf" required>
                  <!-- Opções de UF -->
                </select>
                @error('uf')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            
            <div class="row mb-4">
              <div class="col-xl-3">
                <label for="rol">* No. Rol</label>
                <input type="number" class="form-control" id="rol" name="rol" value="{{ old('rol') }}" required>
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
          </div>                       
      </div>
    </div>
  </blockquote>  
  </div>