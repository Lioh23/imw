<div class=" card tab-pane fade show active" id="border-top-dados-pessoal" role="tabpanel"
    aria-labelledby="border-top-dados-pessoais">
    <div class="card-body">
        <h5 class="card-title">{{ $membro['nome'] }}</h5>
        <div class="card mb-3">
            <input type="date" class="card-text" name="data_nascimento" value="{{ old('data_nascimento', optional($membro['data_nascimento'])->format('Y-m-d')) }}" style="border: none; text-align: left; background: tranparent" readonly>
        </div>
    </div>
</div>

