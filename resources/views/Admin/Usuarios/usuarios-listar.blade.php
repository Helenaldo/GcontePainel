@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h3>
        Usuários
        <a href="{{route('usuarios.create')}}" class="btn btn-sm btn-success">Novo Usuário</a>
    </h3>
@endsection

@section('content')
    <div class="card">

        <table class="table table-hover"  id="tabela">
            <thead>
            <tr>
                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="Nome" type="text" placeholder="Nome" style="font-weight: bold;">
                    </div>
                </th>

                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="email" type="text" placeholder="E-mail" style="font-weight: bold;">
                    </div>
                </th>

                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="perfil" type="text" placeholder="Perfil" style="font-weight: bold;">
                    </div>
                </th>

                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="ativo" type="text" placeholder="Ativo" style="font-weight: bold;">
                    </div>
                </th>

                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-paper-plane"></i></span>
                        </div>
                        <input class="form-control" type="text" placeholder="AÇÕES" style="font-weight: bold; background-color: transparent;" disabled>
                    </div>
                </th>
            </tr>
        </thead>
            @if ($usuarios->total())

            @foreach ($usuarios as $usuario)
            <tbody>
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->perfil }}</td>
                    <td>{{ $usuario->ativo ? 'Sim' : 'Não' }}</td>
                    <td>
                        <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id ])}}" class="btn btn-sm btn-primary">Editar</a>
                        <form class="d-inline" method="POST" action="{{ route('usuarios.destroy', ['usuario' => $usuario->id]) }}" onsubmit="return confirm('Tem certeza que deseja desativar este usuário?')">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-{{ $usuario->ativo ? 'warning' : 'success' }}">{{ $usuario->ativo ? 'Desativar' : 'Ativar' }}</button>
                        </form>
                        <a href="{{ route('alterarSenha', $usuario->id) }}" class="btn btn-sm btn-secondary">Alterar Senha</a>
                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="4">
                        Não existem usuários cadastrados!
                    </td>
                </tr>

            @endif
        </tbody>
        </table>

        {{ $usuarios->links('pagination::bootstrap-4') }}
    </div>
@endsection

@section('css')
    <Style>
        td {
            white-space: nowrap;
        }
    </Style>
    <link href="https://cdnjs-cloudflare-com.translate.goog/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet"/>
@endsection

@section('js')
    <script src="/assets/js/filtrar.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    @foreach(['success', 'error', 'info', 'warning'] as $type)
        @if(session($type))
            @include("Components.toast-$type")
        @endif
    @endforeach

@endsection


