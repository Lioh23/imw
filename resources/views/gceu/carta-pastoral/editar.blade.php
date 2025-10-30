@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'GCEU', 'url' => '/gceu/lista', 'active' => false],
    ['text' => 'Carta Pastoral', 'url' => '/gceu/carta-pastoral/', 'active' => false],
    ['text' => 'Editar', 'url' => '#', 'active' => true]
]"></x-breadcrumb>
@endsection

@include('extras.alerts')

@section('content')
<div id="tableHover" class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Editar carta pastoral</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            @if($cartaPastoral)
            <form class="form-vertical" action="{{ route('gceu.carta-pastoral.update',$cartaPastoral->id) }}" id="form_create_gceu" method="post">
                @csrf
                <div class="row">
                    <div class="form-group mb-4 col-12">
                        <label class="control-label" for="titulo">* Título</label>
                        <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" id="titulo" required placeholder="Título" minlength="4" value="{{ $cartaPastoral->titulo }}" maxlength="150">
                        @error('titulo')
                            <div class="invalid-feedback">{{  $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-4 col-12">
                        <label class="control-label" for="conteudo">* Carta Pastoral</label>
                        <textarea name="conteudo" id="conteudo" class="form-control @error('conteudo') is-invalid @enderror" placeholder="Introdução">{{ $cartaPastoral->conteudo }}</textarea>
                        @error('conteudo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <input type="submit" value="Atualizar" class="btn btn-primary btn-lg mt-3">
            </form>
            @else
            <div class="alert alert-warning" role="alert">
               Carta pastoral não encontrada.
            </div>
            @endif
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
                    external_filemanager_path:"/gceu/tinymce/filemanager/",
                    filemanager_title:"Procurar imagem" ,
                    external_plugins: { "filemanager" : "{{ asset('gceu/tinymce/filemanager/plugin.min.js') }}"},
                    content_css: ['//www.tinymce.com/css/codepen.min.css']
        });
    </script>
@endsection
