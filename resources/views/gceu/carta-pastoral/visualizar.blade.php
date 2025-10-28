<style>
    .blockui-growl-message {
        display: none;
        text-align: left;
        padding: 15px;
        background-color: #455a64;
        color: #fff;
        border-radius: 3px;
    }

    .blockui-animation-container {
        display: none;
    }

    .multiMessageBlockUi {
        display: none;
        background-color: #455a64;
        color: #fff;
        border-radius: 3px;
        padding: 15px 15px 10px 15px;
    }

    .multiMessageBlockUi i {
        display: block
    }
</style>

<div class="modal-header">
    <h5 class="modal-title">Dados: {{ $gceu->nome }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <div class="tab-content">
                <table class="table table-bordered table-striped table-hover mb-4 dataTable no-footer">
                    <thead>
                        <tr><th>Nome:</th><th>Anfitriao:</th><th>Contato:</th> <th>E-mail:</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>{{ $gceu->nome }}</td><td>{{ $gceu->anfitriao }}</td> <td>{{ $gceu->contato }}</td> <td>{{ $gceu->email }}</td></tr>
                    </tbody>
                    <thead>
                        <tr><th>CEP:</th><th>Endereco:</th><th>Número:</th> <th>Bairro:</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>{{ $gceu->cep }}</td><td>{{ $gceu->endereco }}</td> <td>{{ $gceu->numero }}</td>  <td>{{ $gceu->bairro }}</td></tr>
                    </tbody>
                    <thead>
                        <tr><th>Cidade:</th><th>UF:</th><th>Igreja:</th> <th>Congregação:</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>{{ $gceu->cidade }}</td><td>{{ $gceu->uf }}</td> <td>{{ $gceu->igreja }}</td>  <td>{{ $gceu->congregacao }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
