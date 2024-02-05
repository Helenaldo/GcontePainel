@extends('adminlte::page')

@section('title', 'Contatos de Clientes')

@section('content_header')
<div class="row">
    <div class="col-sm-3">
        <h3>
            Contatos
            <a href="{{route('contatos.create')}}" class="btn btn-sm btn-success">Novo Contato</a>
        </h3>
    </div>
    <div class="col-sm-9">
        <form action="{{ route('contatos.index') }}" method="GET">
            <div class="input-group input-group-sm" style="width: 300px;">
                <input type="text" id="table_search" name="pesquisa" class="form-control float-right" value="{{ $pesquisa }}" placeholder="Pesquisar...">
                <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
                </button>
                </div>
                </div>
            </form>
    </div>
</div>

@endsection

@section('content')
    <div class="card">

        <table class="table table-hover" id="tabela">
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Contato</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
            @if ($contatos->total())

            @foreach ($contatos as $contato)
            <tbody>
                <tr>
                    <td>{{$contato->cliente->nome}}</td>
                    <td>{{$contato->nome}}</td>
                    <td>{{$contato->email}}</td>
                    <td>{{$contato->telefone}}</td>
                    <td>
                        {{-- <a href="#" class="btn btn-sm btn-warning">Ver</a> --}}
                        <a href="{{ route('contatos.edit', ['contato' => $contato->id ])}}" class="btn btn-sm btn-primary">Editar</a>
                        <form class="d-inline" method="POST" action="{{ route('contatos.destroy', ['contato' => $contato->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir este registro?')">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">Exluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="4">
                        Não existem contatos cadastrados!
                    </td>
                </tr>

            @endif
            <tbody>
        </table>

        {{ $contatos->links('pagination::bootstrap-4') }}
    </div>

@endsection

@section('css')
    <link href="https://cdnjs-cloudflare-com.translate.goog/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet"/>
@endsection

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @foreach(['success', 'error', 'info', 'warning'] as $type)
        @if(session($type))
            @include("Components.toast-$type")
        @endif
    @endforeach

@endsection
