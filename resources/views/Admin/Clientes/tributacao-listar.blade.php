@extends('adminlte::page')

@section('title', 'Contatos de Clientes')

@section('content_header')
    <h3>
        Tributação por Cliente
        <a href="{{route('tributacao.create')}}" class="btn btn-sm btn-success">Nova Tributação</a>
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
                        <input class="form-control" id="tributacao" type="text" placeholder="Tributação" style="font-weight: bold;">
                    </div>
                </th>
                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="aPartirDe" type="text" placeholder="A partir de:" style="font-weight: bold;">
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
            @if ($tributacoes->total())

            @foreach ($tributacoes as $tributacao)
            <tbody>
                <tr>
                    <td>{{$tributacao->cliente->nome}}</td>
                    <td>{{$tributacao->tipo}}</td>
                    <td>{{\Carbon\Carbon::parse($tributacao->data)->format('d/m/Y')}}</td>
                    <td>
                        {{-- <a href="#" class="btn btn-sm btn-warning">Ver</a> --}}
                        <a href="{{ route('tributacao.edit', ['tributacao' => $tributacao->id ])}}" class="btn btn-sm btn-primary">Editar</a>
                        <form class="d-inline" method="POST" action="{{ route('tributacao.destroy', ['tributacao' => $tributacao->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir este registro?')">
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
                        Não existem tibutações cadastradas!
                    </td>
                </tr>

            @endif
            </tbody>
        </table>

        {{ $tributacoes->links('pagination::bootstrap-4') }}
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
