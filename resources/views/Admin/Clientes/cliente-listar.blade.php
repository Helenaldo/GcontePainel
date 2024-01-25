@extends('adminlte::page')
@section('title', 'Clientes')
@section('content_header')
<div class="row">
    <div class="col-sm-2">
        <h3>
            Clientes
            <a href="{{route('clientes.create')}}" class="btn btn-sm btn-success">Novo Cliente</a>
        </h3>
    </div>
    <div class="col-sm-3">
        <form method="POST" action="{{ route('clientesFiltrar') }}">
            @csrf
            <div class="form-group">
                <div class="d-inline custom-radio">
                    <input type="radio" id="ativos" value="ativos" name="r1" {{ $filtro == 'ativos' ? 'checked' : '' }} onclick="this.form.submit()">
                    <label for="ativos">
                        Ativos
                    </label>
                </div>
                <div class="d-inline custom-radio">
                    <input type="radio" id="inativos" value="inativos" name="r1" {{ $filtro == 'inativos' ? 'checked' : '' }} onclick="this.form.submit()">
                    <label for="inativos">
                        Inativos
                    </label>
                </div>
                <div class="d-inline custom-radio">
                    <input type="radio" id="todos" value="todos" name="r1" {{ $filtro == 'todos' ? 'checked' : '' }} onclick="this.form.submit()">
                    <label for="todos">
                    Todos
                    </label>
                </div>
            </div>

        </form>


    </div>

</div>
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
                        <input class="form-control" id="fantasia" type="text" placeholder="Fantasia" style="font-weight: bold;">
                    </div>
                </th>
                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="cnpj-cpf" type="text" placeholder="CNPJ/CPF" style="font-weight: bold;">
                    </div>
                </th>
                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="cidade" type="text" placeholder="Cidade" style="font-weight: bold;">
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
        @if ($clientes->total())
        @foreach ($clientes as $cliente)
        <tbody>

            @php
                $class = '';
                if($cliente->data_saida != null) {
                    $class = 'table-danger';
                }
            @endphp
            <tr class="{{ $class }}">
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->fantasia }}</td>
                <td>{{ $cliente->cpf_cnpj }}</td>
                <td>{{ $cliente->cidade ? $cliente->cidade->municipio : 'Sem cidade associada' }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-warning">Ver</a>
                    <a href="{{ route('clientes.edit', ['cliente' => $cliente->id, 'cidade' => $cliente->cidade_id  ])}}" class="btn btn-sm btn-primary">Editar</a>
                    <form class="d-inline" method="POST" action="{{ route('clientes.destroy', ['cliente' => $cliente->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir este registro?')">
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
                    Não existem clientes cadastrados!
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    {{ $clientes->links('pagination::bootstrap-4') }}
</div>
@endsection

@section('css')
    <Style>
        td {
        white-space: nowrap;
        }
    </Style>
    <link href="/assets/css/custom.css" rel="stylesheet"/>
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
