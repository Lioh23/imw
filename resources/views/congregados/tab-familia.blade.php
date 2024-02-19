<div class="tab-pane fade" id="border-top-familia" role="tabpanel" aria-labelledby="border-top-familiar">
  <blockquote class="blockquote">
    <div class="row mb-4">
      <div class="col-xl-6">
        <label>Nome da Mãe</label>
        <input type="text" class="form-control" id="mae" name="mae" value="{{ old('mae') }}">
        @error('mae')
          <span class="help-block text-danger">{{ $message }}</span>
        @enderror
      </div>
      <div class="col-xl-6">
        <label>Nome do Pai</label>
        <input type="text" class="form-control" id="pai" name="pai" value="{{ old('pai') }}">
        @error('pai')
          <span class="help-block text-danger">{{ $message }}</span>
        @enderror
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-xl-6">
        <label>Nome do Cônjuge</label>
        <input type="conjuge" class="form-control" id="conjuge" name="conjuge" value="{{ old('conjuge') }}">
          @error('conjuge')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
      </div>
      <div class="col-xl-3">
        <label>Data do Casamento</label>
        <input type="date" class="form-control" id="dtcasamento" name="dtcasamento" value="{{ old('dtcasamento') }}">
          @error('dtcasamento')
          <span class="help-block text-danger">{{ $message }}</span>
          @enderror
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-xl-12">
        <label>Filhos</label>
        <input type="filhos" class="form-control" id="filhos" name="filhos" value="{{ old('filhos') }}">
          @error('filhos')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-xl-12">
        <label>Histórico Familiar</label>
        <input type="hfamiliar" class="form-control" id="hfamiliar" name="hfamiliar" value="{{ old('hfamiliar') }}">
          @error('hfamiliar')
            <span class="help-block text-danger">{{ $message }}</span>
          @enderror
      </div>
    </div>
  </blockquote>
  
</div>