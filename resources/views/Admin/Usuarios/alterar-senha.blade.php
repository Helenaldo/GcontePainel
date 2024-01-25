@extends('adminlte::page')
@section('title', 'Senha do Usuário')
@section('content_header')
<h3>Alterar Senha do Usuário</h3>
@endsection
@section('content')
<form action="{{ route('alterarSenhaAction', ['usuario' => $usuario->id]) }}" method="POST" class="form-horizontal">
    @method('PUT')
    @csrf

    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">

                <div class="col-md-3">
                    <label class="col-form-label" id="nome_contato" for="nome_contato">Nome:</label>
                    <input type="text" class="form-control" value="{{ $usuario->name }}" required disabled>
                </div>

                <div class="col-md-3">
                    <label for="email" class="col-form-label">E-mail:</label>
                    <input type="email" class="form-control" value="{{ $usuario->email }}" required disabled>
                </div>

                <div class="col-md-2">
                    <label for="perfil" class="col-form-label">Perfil:</label>
                    <input type="text" class="form-control" value="{{ $usuario->perfil }}" required disabled>
                </div>

                <div class="col-md-2 input-group">
                    <label for="password" class="col-form-label">Senha:* </label>
                    <div class="input-group-append">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>

                        <span class="input-group-text" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-2 input-group">
                    <label for="password_confirmation" class="col-form-label">Confirmar Senha:* </label>
                    <div class="input-group-append">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>

                        <span class="input-group-text" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

            </div>

        </div>
        <div class="card-footer">
            {{-- Botões --}}
            <div class="row" >
                <div class="col-md-12 text-right" >
                    <a href="{{route('usuarios.index')}}" type="button" class="btn btn-secondary">Fechar</a>
                    <input type="submit" value="Alterar" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
    <script src="/assets/js/mostrar-senha.js" type="text/javascript"></script>
    <script>

    </script>


@endsection

@section('css')
    <style>
    .input-group .input-group-append .input-group-text {
        cursor: pointer;
    }
    </style>
@endsection
