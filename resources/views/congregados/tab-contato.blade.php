<div class="tab-pane fade" id="border-top-contato" role="tabpanel" aria-labelledby="border-top-contatos">
    <blockquote class="blockquote">
      <div class="row mb-4">
        <div class="col-xl-3">
          <label for="sexo">Telefone Preferencial</label>
          <input type="text" class="form-control" id="telefone_preferencial" name="telefone_preferencial" value="{{ old('telefone_preferencial', $pessoa->contato->telefone_preferencial) }}">
          @error('telefone_preferencial')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-3">
          <label for="sexo">Telefone Alternativo</label>
          <input type="text" class="form-control" id="telefone_alternativo" name="telefone_alternativo" value="{{ old('telefone_alternativo', $pessoa->contato->telefone_alternativo) }}">
          @error('telefone_alternativo')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-3">
          <label for="sexo">Telefone Whatsapp</label>
          <input type="text" class="form-control" id="telefone_whatsapp" name="telefone_whatsapp" value="{{ old('telefone_whatsapp', $pessoa->contato->telefone_whatsapp) }}">
          @error('telefone_whatsapp')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-xl-3">
          <label for="sexo">E-mail Preferencial</label>
          <input type="email" class="form-control" id="email_preferencial" name="email_preferencial" value="{{ old('email_preferencial', $pessoa->contato->email_preferencial) }}">
          @error('email_preferencial')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-3">
          <label for="sexo">E-mail Alternativo</label>
          <input type="email" class="form-control" id="email_alternativo" name="email-alternativo"  value="{{ old('email_alternativo', $pessoa->contato->email_alternativo) }}">
          @error('email_alternativo')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-xl-2">
          <label for="cep">CEP</label>
          <input type="text" class="form-control" id="cep" name="cep"  value="{{ old('cep', $pessoa->contato->cep) }}">
          @error('cep')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="endereco">Endereço</label>
          <input type="text" class="form-control" id="endereco" name="endereco"  value="{{ old('endereco', $pessoa->contato->endereco) }}">
          @error('endereco')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-2">
          <label for="numero">Número</label>
          <input type="number" class="form-control" id="numero" name="numero"  value="{{ old('numero', $pessoa->contato->numero) }}">
          @error('numero')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="complemento">Complemento</label>
          <input type="text" class="form-control" id="complemento" name="complemento"  value="{{ old('complemento', $pessoa->contato->complemento) }}">
          @error('complemento')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-xl-4">
          <label for="bairro">Bairro</label>
          <input type="text" class="form-control" id="bairro" name="bairro"  value="{{ old('bairro', $pessoa->contato->bairro) }}">
          @error('bairro')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="cidade">Cidade</label>
          <input type="text" class="form-control" id="cidade" name="cidade"  value="{{ old('cidade', $pessoa->contato->cidade) }}">
          @error('cidade')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-xl-4">
          <label for="estado">Estado</label>
          <input type="text" class="form-control" id="estado" name="estado"  value="{{ old('estado', $pessoa->contato->estado) }}">
          @error('estado')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-xl-12">
          <label for="observacoes">Observações</label>
          <input type="text" class="form-control" id="observacoes" name="observacoes"  value="{{ old('observacoes', $pessoa->contato->observacoes) }}">
          @error('observacoes')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
    </blockquote>
</div>