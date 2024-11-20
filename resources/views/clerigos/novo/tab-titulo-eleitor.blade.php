<div class="tab-pane fade" id="border-top-titulo-eleitor" role="tabpanel" aria-labelledby="border-top-titulo-eleitor">
    <blockquote class="blockquote">
        <div class="row">
            <div class="col-12 mt-3 col-md-4">
                <label for="titulo_eleitor">Número do Título de Eleitor*</label>
                <input type="text" class="form-control @error('titulo_eleitor') is-invalid @enderror"
                    id="titulo_eleitor" name="titulo_eleitor"
                    value="{{ old('titulo_eleitor') }}" >
                @error('titulo_eleitor')
                    <span class="help-block text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 mt-3 col-md-4">
                <label for="titulo_eleitor_zona">Zona*</label>
                <input type="text" class="form-control @error('titulo_eleitor_zona') is-invalid @enderror"
                    id="titulo_eleitor_zona" name="titulo_eleitor_zona"
                    value="{{ old('titulo_eleitor_zona') }}" >
                @error('titulo_eleitor_zona')
                    <span class="help-block text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 mt-3 col-md-4">
                <label for="titulo_eleitor_secao">Seção*</label>
                <input type="text" class="form-control @error('titulo_eleitor_secao') is-invalid @enderror"
                    id="titulo_eleitor_secao" name="titulo_eleitor_secao"
                    value="{{ old('titulo_eleitor_secao') }}" >
                @error('titulo_eleitor_secao')
                    <span class="help-block text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </blockquote>
</div>
