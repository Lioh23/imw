<div class="tab-pane fade" id="border-top-contato" role="tabpanel" aria-labelledby="border-top-contatos">
    <blockquote class="blockquote">
      <div class="row mb-4">
        <div class="col-xl-3">
          <label for="sexo">Telefone Preferencial</label>
          <input type="text" class="form-control" id="telefone-preferencial" name="telefone-preferencial" value="{{ old('telefone-preferencial') }}">
          @error('telefone-preferencial')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-3">
          <label for="sexo">Telefone Alternativo</label>
          <input type="text" class="form-control" id="telefone-alternativo" name="telefone-alternativo" value="{{ old('telefone-alternativo') }}">
          @error('telefone-alternativo')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-3">
          <label for="sexo">Telefone Whatsapp</label>
          <input type="text" class="form-control" id="telefone-whatsapp" name="telefone-whatsapp" value="{{ old('telefone-whatsapp') }}">
          @error('telefone-whatsapp')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-xl-3">
          <label for="sexo">E-mail Preferencial</label>
          <input type="email" class="form-control" id="email-preferencial" name="email-preferencial" value="{{ old('email-preferencial') }}">
          @error('email-preferencial')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-3">
          <label for="sexo">E-mail Alternativo</label>
          <input type="email" class="form-control" id="email-alternativo" name="email-alternativo" value="{{ old('email-alternativo') }}">
          @error('email-alternativo')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-xl-2">
          <label for="cep">CEP</label>
          <input type="text" class="form-control" id="cep" name="cep" value="{{ old('cep') }}">
          @error('cep')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="endereco">Endereço</label>
          <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('endereco') }}">
          @error('endereco')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-2">
          <label for="numero">Número</label>
          <input type="number" class="form-control" id="numero" name="numero" value="{{ old('numero') }}">
          @error('numero')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="complemento">Complemento</label>
          <input type="text" class="form-control" id="complemento" name="complemento" value="{{ old('complemento') }}">
          @error('complemento')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-xl-4">
          <label for="bairro">Bairro</label>
          <input type="text" class="form-control" id="bairro" name="bairro" value="{{ old('bairro') }}">
          @error('bairro')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="cidade">Cidade</label>
          <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade') }}">
          @error('cidade')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="estado">Estado</label>
          <input type="text" class="form-control" id="estado" name="estado" value="{{ old('estado') }}">
          @error('estado')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-xl-12">
          <label for="observacoes">Observações</label>
          <input type="text" class="form-control" id="observacoes" name="observacoes" value="{{ old('observacoes') }}">
          @error('observacoes')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
    </blockquote>
</div>