@extends('adminlte::page')

@section('title', 'Responsáveis')

@section('content_header')
    <h3>
        Responsáveis
        <a href="{{route('responsabilidades.create')}}" class="btn btn-sm btn-success">Novo Registro</a>
        <a href="#" class="btn btn-sm btn-info">Transferir Responsabilidades</a>
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
                        <input class="form-control" id="empresa" type="text" placeholder="Empresa" style="font-weight: bold;">
                    </div>
                </th>
                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="data" type="text" placeholder="Data" style="font-weight: bold;">
                    </div>
                </th>

                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="contabil" type="text" placeholder="Contábil" style="font-weight: bold;">
                    </div>
                </th>

                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="fiscal" type="text" placeholder="Fiscal" style="font-weight: bold;">
                    </div>
                </th>

                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="pessoal" type="text" placeholder="Pessoal" style="font-weight: bold;">
                    </div>
                </th>

                <th>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input class="form-control" id="paralegal" type="text" placeholder="Paralegal" style="font-weight: bold;">
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
            @if ($responsaveis->total())

            @foreach ($responsaveis as $responsavel)
            {{-- {{dd($users)}} --}}
            <tbody>
                <tr>
                    <td>{{ $responsavel->cliente->nome }}</td>
                    <td>{{ $responsavel->data ? \Carbon\Carbon::parse($responsavel->data)->format('d/m/Y') : ''  }}</td>
                    <td>{{ $responsavel->userContabil ? $responsavel->userContabil->name : 'Sem responsável' }}</td>
                    <td>{{ $responsavel->userPessoal ? $responsavel->userPessoal->name : 'Sem responsável' }}</td>
                    <td>{{ $responsavel->userFiscal ? $responsavel->userFiscal->name : 'Sem responsável' }}</td>
                    <td>{{ $responsavel->userParalegal ? $responsavel->userParalegal->name : 'Sem responsável' }}</td>
                    <td>
                        <a href="{{ route('responsabilidades.edit', $responsavel->id )}}" class="btn btn-sm btn-primary">Editar</a>
                        <form class="d-inline" method="POST" action="{{ route('responsabilidades.destroy', ['responsabilidade' => $responsavel->id]) }}" onsubmit="return confirm('Tem certeza que deseja deletarr este registro?')">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-warning">Deletar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="4">
                        Não existem responsáveis cadastrados!
                    </td>
                </tr>

            @endif
        </tbody>
        </table>

        {{ $responsaveis->links('pagination::bootstrap-4') }}
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


