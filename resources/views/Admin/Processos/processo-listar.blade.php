@extends('adminlte::page')

@section('title', 'Processos')

@section('content_header')

<div class="row">
    <div class="col-sm-2">
        <h3>
            Processos
            <a href="{{route('processo.create')}}" class="btn btn-sm btn-success">Novo Processo</a>

        </h3>
    </div>

    <div class="col-sm-3">
        <form method="GET" action="{{ route('processo.index') }}">

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
                    <input type="radio" id="parados" value="parados" name="r1" {{ $filtro == 'parados' ? 'checked' : '' }} onclick="this.form.submit()">
                    <label for="parados">
                        Parados
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
        <form action="{{ route('processo.index') }}" method="GET">
            <div class="input-group input-group-sm" style="width: 300px;">
                <input type="text" id="table_search" name="pesquisa" class="form-control float-right" value="{{ $pesquisa }}" placeholder="Pesquisar por cliente, título ou status...">
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
                <th>
                    Data
                </th>
                <th>
                    Dias
                </th>
                <th>
                    Clientes
                </th>
                <th>
                    Título
                </th>
                <th>
                   Nº. Protocolo
                </th>
                <th>
                    Status
                </th>
                <th>
                    Criado por:
                </th>
                <th>
                    Ações
                </th>
            </tr>
        </thead>


            {{-- @if ($processos->total()) --}}

            @foreach ($processos as $processo)
            <tbody>
                @php
                    $class = '';
                    if ($processo->status === 'Concluido') {
                        $class = 'table-success';
                    } elseif (!empty($processo->prazo) && $processo->prazo < date('Y-m-d')) {
                        $class = 'table-danger';
                    }
                @endphp

                <tr class="{{ $class }}">
                    <td>{{ $processo->data ? \Carbon\Carbon::parse($processo->data)->format('d/m/Y') : '' }}</td>
                    <td>{{ $processo->diasPassados }}</td>
                    <td>{{$processo->cliente->nome}}</td>
                    <td>{{$processo->titulo}}</td>
                    <td>
                        @if(preg_match('/^(PIP|PIB|PIE|PIN)\d{10}$/', $processo->numero))
                            <a href="https://www.piauidigital.pi.gov.br/sigfacil/processo/acompanhar/co_protocolo/{{ $processo->numero }}"  target="_blank">
                                {{ $processo->numero }}
                            </a>
                        @elseif(preg_match('/^\d+\/\d{4}$/', $processo->numero))
                            <a href="http://slic.semf.teresina.pi.gov.br/AlvaraNovo-war/externo/homeExternoLogado.jsf" target="_blank">
                                {{ $processo->numero }}
                            </a>
                        @else
                            {{ $processo->numero }}
                        @endif
                    </td>
                    <td>{{$processo->status}}</td>

                    <td>{{ explode(' ', $processo->user->name)[0] }}</td>
                    <td>
                        <a href="{{ route('processoMov.index', ['processo' => $processo->id]) }}" class="btn btn-sm btn-warning">Ver</a>

                        @if($processo->status == 'Concluido' )
                            <form class="d-inline" method="POST" action="{{ route('processoFim', ['id' => $processo->id]) }}" onsubmit="return confirm('Tem certeza que deseja reabrir este processo?')">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Reabrir</button>
                            </form>
                        @endif

                        @if($processo->status != 'Concluido' )
                            <a href="{{ route('processo.edit', ['processo' => $processo->id] ) }}" class="btn btn-sm btn-primary">Editar</a>

                            <form class="d-inline" method="POST" action="{{ route('processoFim', ['id' => $processo->id]) }}" onsubmit="return confirm('Tem certeza que deseja finalizar este processo?')">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Finalizar</button>
                            </form>

                            <form class="d-inline" method="POST" action="{{ route('processo.destroy', ['processo' => $processo->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir este registro?')">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>

                        @endif

                    </td>
                </tr>
            @endforeach
            {{-- @else
                <tr>
                    <td colspan="9">
                        Não existem processos cadastrados!
                    </td>
                </tr>

            @endif --}}
        </tbody>
        </table>

        {{-- {{ $processos->links('pagination::bootstrap-4') }} --}}
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

