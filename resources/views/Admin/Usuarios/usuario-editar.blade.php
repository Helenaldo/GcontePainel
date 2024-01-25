@extends('adminlte::page')
@section('title', 'Alterar Usuário')
@section('content_header')
<h3>Alterar Usuário</h3>
@endsection
@section('content')
<form action="{{ route('usuarios.update', ['usuario' => $usuario->id]) }}" method="POST" class="form-horizontal">
    @method('PUT')
    @csrf
    <input type="hidden" name="userId" value="{{ $usuario->id }}">
    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">

                <div class="col-md-4">
                    <label class="col-form-label" id="nome_contato" for="nome_contato">Nome:* </label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $usuario->name }}" required>
                    @error('name')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="email" class="col-form-label">E-mail:* </label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $usuario->email }}" required>
                    @error('email')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="perfil" class="col-form-label">Perfil:* </label>

                    <select name="perfil" id="perfil" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="Administrador" @if($usuario->perfil == 'Administrador') selected @endif>Administrador</option>
                        <option value="Operador" @if($usuario->perfil == 'Operador') selected @endif>Operador</option>

                    </select>

                    @error('perfil')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="ativo" class="col-form-label">Ativo:* </label>

                    <select name="ativo" id="ativo" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="1" @if($usuario->ativo == '1') selected @endif>Sim</option>
                        <option value="0" @if($usuario->ativo == '0') selected @endif>Não</option>

                    </select>

                    @error('perfil')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
            </div>

        </div>
        <div class="card-footer">
            {{-- Botões --}}
            <div class="row" >
                <div class="col-md-12 text-right" >
                    <a href="{{ route('usuarios.index') }}" type="button" class="btn btn-secondary">Fechar</a>
                    <input type="submit" value="Alterar" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

