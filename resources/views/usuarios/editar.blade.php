@extends('template.layout')

@section('extras-css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Segurança', 'url' => '/', 'active' => false],
        ['text' => 'Usuarios', 'url' => '/usuarios/', 'active' => false],
        ['text' => 'Editar', 'url' => '/usuarios/editar/' . $user->id, 'active' => true],
    ]">
    </x-breadcrumb>
@endsection

@include('extras.alerts')

@section('content')
    <div id="tableHover" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Editar Usuário</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form autocomplete="off" class="form-horizontal" method="POST" id="formEditarUsuario"
                    action="{{ route('usuarios.update', $id) }}">
                    @csrf
                    <div class="row mb-1">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>* E-mail</label>
                                <div class="controls">
                                    <input type="email" name="email_hidden" id="email_hidden" class="form-control @error('email') is-invalid @enderror"
                                        autocomplete="off" value="{{ $user->email }}" disabled/>

                                    <input type="hidden" name="email" id="email" value="{{ $user->email }}"/>

                                    @error('email')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>* Nome completo</label>
                                <div class="controls">
                                    <input type="text" name="name_hidden" id="name" class="form-control"  value="{{ $user->name }}" disabled>
                                    <input type="hidden" name="name" id="name" class="form-control" value="{{ $user->name }}">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-4" id="col-perfil">
                            <div class="form-group">
                                <label>* Perfil de Acesso</label>
                                <select class="form-control @error('perfil_id') is-invalid @enderror" name="perfil_id"
                                    >
                                    <option value="">Selecione um perfil</option>

                                    @php
                                    $perfisInstituicao = $user->perfilUser;
                                    @endphp

                                    @foreach ($perfisInstituicao as $index => $perfilUser)
                                        @if ($perfilUser->instituicao_id == session()->get('session_perfil')->instituicao_id)
                                            @foreach ($perfis as $perfil)
                                                <option value="{{ $perfil->id }}"
                                                    {{ $perfilUser->perfil_id == $perfil->id ? 'selected' : '' }}>
                                                    {{ $perfil->nome }}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-lg-4">
                            <div class="form-group">
                                <label>Senha</label>
                                <div class="controls">
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                        autocomplete="new-password" />
                                    @error('password')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Confirmar Senha</label>
                                <div class="controls">
                                    <input type="password" name="password_confirmation" id="confirmPassword"
                                        class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password" />
                                    @error('password_confirmation')
                                     <span class="help-block text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                    </div>


                    <div class="row mt-4">

                    </div>
                    <br><br>
                    <button type="submit" class="btn btn-primary btn-rounded" id="atualizar">Atualizar</button>
                </form>
            </div>
        </div>
    </div>
@endsection


