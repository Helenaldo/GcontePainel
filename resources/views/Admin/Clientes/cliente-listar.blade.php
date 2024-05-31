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
        <form method="GET" action="{{ route('clientes.index') }}">
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
    <div class="col-sm-3">
        <form action="{{ route('clientes.index') }}" method="GET">
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
    <table class="table table-hover"  id="tabela">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Fantasia</th>
                <th>CNPJ/CPF</th>
                <th>Cidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        @if ($clientes->total())
        @foreach ($clientes as $cliente)
        <tbody id="myTable">

            @php
                $class = '';
                if($cliente->data_saida != null) {
                    $class = 'table-danger';
                }
            @endphp
            <tr class="{{ $class }}">
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->fantasia }}</td>
                <td>
                    @php
                    // Remove os caracteres ., / e - do cpf_cnpj
                    $cpfCnpjLimpo = preg_replace('/[.\/-]/', '', $cliente->cpf_cnpj);

                    // Verifica se o cpfCnpjLimpo tem 14 caracteres
                    if (strlen($cpfCnpjLimpo) == 14) {
                        // Monta o link com o CNPJ limpo
                        $url = "https://servicos.receita.fazenda.gov.br/Servicos/cnpjreva/Cnpjreva_Solicitacao.asp?cnpj=" . $cpfCnpjLimpo;

                        // Exibe o link
                        echo "<a href='{$url}' target='_blank'>{$cliente->cpf_cnpj} <i class='fa fa-eye'></i></a>";
                    } else {
                        // Se não tiver 14 caracteres, apenas exibe o cpf_cnpj normalmente
                        echo $cliente->cpf_cnpj;
                    }
                    @endphp
                </td>
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @foreach(['success', 'error', 'info', 'warning'] as $type)
    @if(session($type))
    @include("Components.toast-$type")
    @endif
    @endforeach


@endsection
