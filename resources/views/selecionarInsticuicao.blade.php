<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('theme/assets/img/favicon.ico') }}" />
    <script src="{{ asset('theme/assets/js/libs/jquery-3.1.1.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link href="{{ asset('theme/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('theme/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/elements/miscellaneous.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/tables/table-basic.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
        .swal2-popup .swal2-styled.swal2-cancel {
            color: white!important;
        }
    </style>
    
    @include('extras.alerts')
    
    @section('extras-scripts')
    <script src="{{ asset('theme/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    @endsection
</head>

<body>
    <section class="row flexbox-container justify-content-center align-items-center mt-3">
        <div class="col-xl-10 col-md-10 col-10 ">
          <div class="card bg-transparent shadow-none">
            <div class="card-content">
              <div class="card-body text-center">
                <h3 class="mb-4">Você precisa selecionar uma instituição</h3>
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if($instituicoes->isEmpty())
                    <p>Nenhum instituição de vinculada a este usuário.</p>
                @else
                    <div class="row justify-content-center align-items-center">
                        @foreach ($instituicoes as $instituicao)
                            <div class="col-lg-4 col-md-6 mb-4 ">
                                <div class="card">
                                    <div class="card-header bg-primary text-white text-bold-600">
                                        {{ $instituicao->nome }}
                                    </div>
                                    <div class="card-body">
                                    </div>
                                    <div class="card-footer text-center">
                                        <form action="{{ route('selecionar.instituicao') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="instituicao_id" value="{{ $instituicao->id }}">
                                            <input type="hidden" name="instituicao_nome" value="{{ $instituicao->nome }}">
    
                                            <button type="submit" class="btn btn-dark">
                                                Selecionar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </section>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('theme/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
 </body>

</html>
