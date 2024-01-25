@extends('adminlte::page')

@section('title', 'Contatos de Clientes')

@section('content_header')
    <h3>
        Contatos
        <a href="{{route('contatos.create')}}" class="btn btn-sm btn-success">Novo Contato</a>
    </h3>
@endsection

@section('content')
    <div class="card">

        <table class="table table-hover" id="tabela">
            <thead>
            <tr>
                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="cliente" type="text" placeholder="Cliente" style="font-weight: bold;">
                    </div>
                </th>
                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="contato" type="text" placeholder="Contato" style="font-weight: bold;">
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
                        <input class="form-control" id="telefone" type="text" placeholder="Telefone" style="font-weight: bold;">
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
    <script src="/assets/js/filtrar.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @foreach(['success', 'error', 'info', 'warning'] as $type)
        @if(session($type))
            @include("Components.toast-$type")
        @endif
    @endforeach

@endsection
