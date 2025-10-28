@extends('template.layout')
@section('breadcrumb')
<!-- <x-breadcrumb :breadcrumbs="[
    ['text' => 'GCEU', 'url' => '/gceu/lista', 'active' => false],
    ['text' => 'Carta Pastoral', 'url' => '/gceu/carta-pastoral/', 'active' => false],
    ['text' => 'Novo', 'url' => '#', 'active' => true]
]"></x-breadcrumb> -->
<div id="breadcrumbArrowed" class="col-xl-12 col-lg-12 layout-spacing ml-2 mt-3">
    <nav class="breadcrumb-two" aria-label="breadcrumb">
        <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                <a href="/gceu/lista">GCEU</a>
            </li>
                <li class="breadcrumb-item ">
                <a href="/gceu/carta-pastoral/{{ $gceu->id }}">Carta Pastoral</a>
            </li>
                <li class="breadcrumb-item active">
                <a href="#">Novo</a>
            </li>
        </ol>
    </nav>
</div>
@endsection
@include('extras.alerts')
@section('content')
<div id="tableHover" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Nova carta pastoral do GCEU: <u>{{ $gceu->nome }}</u></h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <form class="form-vertical" action="{{ route('gceu.store') }}" id="form_create_gceu" method="post">
                @csrf
                <div class="row">
                    <div class="form-group mb-4 col-12">
                        <label class="control-label" for="nome">* Título</label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="nome" required placeholder="Título" minlength="4" value="{{ old('nome') }}" maxlength="150">
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-4 col-12">
                        <label class="control-label" for="anfitriao">* Carta Pastoral</label>
                        <textarea name="anfitriao" id="anfitriao" class="form-control @error('anfitriao') is-invalid @enderror" placeholder="Introdução" value="{{ old('anfitriao') }}"></textarea>
                        @error('anfitriao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <input type="submit" value="Salvar" class="btn btn-primary btn-lg mt-3">
            </form>
        </div>
    </div>
</div>
@endsection

@section('extras-scripts')
    <script src="{{ asset('gceu/tinymce/tinymce.min.js') }}?time={{ time() }}"></script>
    <script>
        tinymce.init({
					selector: 'textarea',
					height: 250,
					menubar: true,
					language: "pt_BR",
					theme: "modern",
					plugins: [
					'advlist autolink lists link image charmap print preview anchor',
					'searchreplace visualblocks code fullscreen',
					'insertdatetime media table contextmenu paste code',
					'responsivefilemanager',
					],
					toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent forecolor | responsivefilemanager ",
					relative_urls : false,
					remove_script_host : false,
					image_advtab: true,
					external_filemanager_path:"/resources/js/tinymce_tsa/filemanager/",
					filemanager_title:"Procurar imagem" ,
					external_plugins: { "filemanager" : "/resources/js/tinymce_tsa/filemanager/plugin.min.js"},
					content_css: ['//www.tinymce.com/css/codepen.min.css']
		});
    </script>
@endsection
