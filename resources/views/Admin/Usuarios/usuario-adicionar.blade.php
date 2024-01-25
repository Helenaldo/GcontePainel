@extends('adminlte::page')
@section('title', 'Novo Usuário')
@section('content_header')
<h3>Novo Usuário</h3>
@endsection
@section('content')
<form action="{{ route('usuarios.store') }}" method="POST" class="form-horizontal">
    @csrf
    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">

                <div class="col-md-3">
                    <label class="col-form-label" id="nome_contato" for="nome_contato">Nome:* </label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="email" class="col-form-label">E-mail:* </label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-1">
                    <label for="perfil" class="col-form-label">Perfil:* </label>

                    <select name="perfil" id="perfil" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="Administrador" @if(old('perfil') == 'Administrador') selected @endif>Administrador</option>
                        <option value="Operador" @if(old('perfil') == 'Operador') selected @endif>Operador</option>

                    </select>

                    @error('perfil')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-1">
                    <label for="ativo" class="col-form-label">Ativo:* </label>

                    <select name="ativo" id="ativo" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="1" @if(old('ativo') == '1') selected @endif>Sim</option>
                        <option value="0" @if(old('ativo') == '0') selected @endif>Não</option>

                    </select>

                    @error('perfil')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="password" class="col-form-label">Senha:* </label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
                    @error('password')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="password_confirmation" class="col-form-label">Confirmar Senha:* </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
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
                    <input type="submit" value="Cadastrar" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

