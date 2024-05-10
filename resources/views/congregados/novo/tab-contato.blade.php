<div class="tab-pane fade" id="border-top-contato" role="tabpanel" aria-labelledby="border-top-contatos">
    <blockquote class="blockquote">
      <div class="row mb-4">
        <div class="col-xl-3">
          <label for="sexo">Telefone</label>
          <input type="text" class="form-control @error('telefone_preferencial') is-invalid @enderror" id="telefone_preferencial" name="telefone_preferencial" value="{{ old('telefone_preferencial') }}">
          @error('telefone_preferencial')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-3">
          <label for="sexo">Telefone Alternativo</label>
          <input type="text" class="form-control @error('telefone_alternativo') is-invalid @enderror" id="telefone_alternativo" name="telefone_alternativo" value="{{ old('telefone_alternativo') }}">
          @error('telefone_alternativo')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-3">
          <label for="sexo">Telefone Whatsapp</label>
          <input type="text" class="form-control @error('telefone_whatsapp') is-invalid @enderror" id="telefone_whatsapp" name="telefone_whatsapp" value="{{ old('telefone_whatsapp') }}">
          @error('telefone_whatsapp')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-xl-3">
          <label for="sexo">E-mail Preferencial</label>
          <input type="email" class="form-control @error('email_preferencial') is-invalid @enderror" id="email_preferencial" name="email_preferencial" value="{{ old('email_preferencial') }}">
          @error('email_preferencial')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
     {{--    <div class="col-xl-3">
          <label for="sexo">E-mail Alternativo</label>
          <input type="email" class="form-control @error('email_alternativo') is-invalid @enderror" id="email_alternativo" name="email_alternativo"  value="{{ old('email_alternativo') }}">
          @error('email_alternativo')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div> --}}
      </div>

      <div class="row mb-4">
        <div class="col-xl-2">
          <label for="cep">CEP</label>
          <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep" name="cep"  value="{{ old('cep') }}">
          @error('cep')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="endereco">Endereço</label>
          <input type="text" class="form-control" id="endereco" name="endereco"  value="{{ old('endereco') }}">
          @error('endereco')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-2">
          <label for="numero">Número</label>
          <input type="number" class="form-control" id="numero" name="numero"  value="{{ old('numero') }}">
          @error('numero')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="complemento">Complemento</label>
          <input type="text" class="form-control" id="complemento" name="complemento"  value="{{ old('complemento') }}">
          @error('complemento')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-xl-4">
          <label for="bairro">Bairro</label>
          <input type="text" class="form-control" id="bairro" name="bairro"  value="{{ old('bairro') }}">
          @error('bairro')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="cidade">Cidade</label>
          <input type="text" class="form-control" id="cidade" name="cidade"  value="{{ old('cidade') }}">
          @error('cidade')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="estado">Estado</label>
          <input type="text" class="form-control" id="estado" name="estado"  value="{{ old('estado') }}">
          @error('estado')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-xl-12">
          <label for="observacoes">Observações</label>
          <input type="text" class="form-control" id="observacoes" name="observacoes"  value="{{ old('observacoes') }}">
          @error('observacoes')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
    </blockquote>
</div>
