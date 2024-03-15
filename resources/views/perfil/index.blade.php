@extends('template.layout')

@section('breadcrumb')
<x-breadcrumb :breadcrumbs="[
    ['text' => 'Segurança', 'url' => '#', 'active' => false],
    ['text' => 'Perfil', 'url' => '/perfil', 'active' => true],
]"></x-breadcrumb>
@endsection

@section('content')
@include('extras.alerts-error-all')
@include('extras.alerts')

<div style="margin: 0px 23px;">
    <form method="POST" action="{{ route('perfil.update', ['id' => $usuario->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <blockquote class="blockquote">
                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <label for="name">* Nome</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $usuario->name) }}">
                            @error('name')
                            <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-xl-6">
                            <label for="email">* E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->email) }}">
                            @error('email')
                            <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-xl-4">
                            <label for="password">* Nova senha</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                            <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-xl-4">
                            <label for="password_confirmation">* Confirmar nova senha</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                            <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" title="atualizar" class="btn btn-primary btn-lg">Atualizar</button>
                    </div>
                </blockquote>
            </div>
        </div>
    </form>
</div>
@endsection
