<div class="tab-pane fade" id="border-top-familia" role="tabpanel" aria-labelledby="border-top-familiar">
  <blockquote class="blockquote">
    <div class="row mb-4">
      <div class="col-xl-6">
        <label>Nome da Mãe</label>
        <input type="text" class="form-control" id="mae_nome" name="mae_nome" value="{{ old('mae', optional($pessoa->familiar)->mae_nome) }}" maxlength="100">
        @error('mae')
          <span class="help-block text-danger">{{ $message }}</span>
        @enderror
      </div>
      <div class="col-xl-6">
        <label>Nome do Pai</label>
        <input type="text" class="form-control" id="pai_nome" name="pai_nome" value="{{ old('pai_nome', optional($pessoa->familiar)->pai_nome) }}" maxlength="100">
        @error('pai')
          <span class="help-block text-danger">{{ $message }}</span>
        @enderror
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-xl-6">
        <label>Nome do Cônjuge</label>
        <input type="text" class="form-control" id="conjuge_nome" name="conjuge_nome" value="{{ old('conjuge_nome', optional($pessoa->familiar)->conjuge_nome) }}" maxlength="100">
          @error('conjuge')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
      </div>
      <div class="col-xl-3">
        <label>Data do Casamento</label>
        <input type="date" class="form-control @error('data_casamento') is-invalid @enderror" id="data_casamento" name="data_casamento" value="{{ old('data_casamento', optional($pessoa->familiar)->data_casamento) }}">
          @error('data_casamento')
          <span class="help-block text-danger">{{ $message }}</span>
          @enderror
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-xl-12">
        <label>Filhos</label>
        <input type="text" class="form-control" id="filhos" name="filhos" value="{{ old('filhos', optional($pessoa->familiar)->filhos) }}" maxlength="1000">
          @error('filhos')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-xl-12">
        <label>Histórico Familiar</label>
        <input type="text" class="form-control" id="historico_familiar" name="historico_familiar" value="{{ old('historico_familiar', optional($pessoa->familiar)->historico_familiar) }}" maxlength="1000">
          @error('hfamiliar')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
      </div>
    </div>
  </blockquote>

</div>
