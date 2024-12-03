<div class="tab-pane fade" id="border-top-habilitacao" role="tabpanel" aria-labelledby="border-top-habilitacao">
    <blockquote class="blockquote">
        <div class="row">
            <div class="col-12 mt-3 col-md-4">
                <label for="habilitacao">Número da Habilitação*</label>
                <input type="text" class="form-control @error('habilitacao') is-invalid @enderror" id="habilitacao"
                    name="habilitacao" value="{{ old('habilitacao', $clerigo->habilitacao) }}" >
                @error('habilitacao')
                    <span class="help-block text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 mt-3 col-md-4">
                <label for="habilitacao_categoria">Categoria*</label>
                <select class="form-control @error('habilitacao_categoria') is-invalid @enderror"
                    id="habilitacao_categoria" name="habilitacao_categoria">
                    <option value="A"
                        {{ old('habilitacao_categoria', $clerigo->habilitacao_categoria) == 'A' ? 'selected' : '' }}>A
                    </option>
                    <option value="B"
                        {{ old('habilitacao_categoria', $clerigo->habilitacao_categoria) == 'B' ? 'selected' : '' }}>B
                    </option>
                    <option value="C"
                        {{ old('habilitacao_categoria', $clerigo->habilitacao_categoria) == 'C' ? 'selected' : '' }}>C
                    </option>
                    <option value="D"
                        {{ old('habilitacao_categoria', $clerigo->habilitacao_categoria) == 'D' ? 'selected' : '' }}>D
                    </option>
                    <option value="E"
                        {{ old('habilitacao_categoria', $clerigo->habilitacao_categoria) == 'E' ? 'selected' : '' }}>E
                    </option>
                </select>
                @error('habilitacao_categoria')
                    <span class="help-block text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 mt-3 col-md-4">
                <label for="habilitacao_emissor">Emissor</label>
                <input type="text" class="form-control @error('habilitacao_emissor') is-invalid @enderror"
                    id="habilitacao_emissor" name="habilitacao_emissor"
                    value="{{ old('habilitacao_emissor', $clerigo->habilitacao_emissor) }}">
                @error('habilitacao_emissor')
                    <span class="help-block text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 mt-3 col-md-4">
                <label for="habilitacao_uf">Estado</label>
                <select class="form-control @error('habilitacao_uf') is-invalid @enderror"
                    id="habilitacao_uf" name="habilitacao_uf">
                    @foreach ($ufs as $key => $value)
                        <option value="{{ $key }}" {{ old('habilitacao_uf', $clerigo->habilitacao_uf) == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @error('habilitacao_uf')
                    <span class="help-block text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </blockquote>
</div>
