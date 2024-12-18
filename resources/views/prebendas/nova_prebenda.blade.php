@extends('template.layout')

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Clérigos', 'url' => '/clerigos', 'active' => false],
        ['text' => 'Prebenda', 'url' => '#', 'active' => true],
    ]">
    </x-breadcrumb>
@endsection

@section('extras-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/select2/select2.min.css') }}" rel="stylesheet" />

    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white !important;
        }

        .modal-xl {
            max-width: 90% !important;
        }
    </style>
@endsection

@include('extras.alerts')

@section('content')
    <div class="container-fluid" style="background: #fff">
        <div class="widget-header">
            <h4>Nova Prebenda</h4>
        </div>

        <form class="py-2 px-3" method="POST" action="{{ route('clerigos.prebendas.storePrebenda') }}">
            @csrf
            <div class="row">
                <div class="col-12 mt-3 col-md-4">
                    <label for="ano">* Ano</label>
                    <input class="form-control" type="number" id="ano" name="ano" value="{{ old('ano') }}"
                        @error('ano') is-invalid @enderror>

                    @error('ano')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 mt-3 col-md-4">
                    <label for="valor">* Valor</label>
                    <input class="form-control" type="number" id="valor" name="valor" step="0.01"
                        value="{{ old('valor') }}" @error('valor') is-invalid @enderror>
                    @error('valor')
                        <span class="help-block text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>



            <button class="btn btn-primary my-4">Salvar</button>
        </form>
    </div>
@endsection

@section('extras-scripts')
    <script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/select2/custom-select2.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/i18n/pt-BR.js"></script>
    <script>
        $('.basic').select2({
            placeholder: 'Selecione',
            allowClear: true
        });
    </script>
@endsection
