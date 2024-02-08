@extends('adminlte::page')
@section('title', 'Movimentar Processo')
@section('content')
{{-- CABEÇA DO PROCESSO --}}
<h3>Movimentar Processo
    <a href="{{ route('processo.index') }}" type="button" class="btn btn-sm btn-secondary">Fechar</a>
</h3>
<div class="card">
    <div class="card-body">
        {{-- Linha 1 GRID --}}
        <div class="row">
            <div class="col-md-4">
                <label class="col-form-label col-form-label-sm" for="cliente">Cliente:</label>
                <input type="text" name="cliente" id="cliente" class="form-control form-control-sm" value="{{ $processo->cliente->nome }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="col-form-label  col-form-label-sm" for="titulo">Título: </label>
                <input type="text" name="titulo" id="titulo" class="form-control form-control-sm" value="{{ $processo->titulo }}" readonly>
            </div>
            <div class="col-md-2">
                <label class="col-form-label col-form-label-sm" for="titulo">Número:</label>
                @if(preg_match('/^(PIP|PIB|PIE|PIN)\d{10}$/', $processo->numero))
                    <a href="https://www.piauidigital.pi.gov.br/sigfacil/processo/acompanhar/co_protocolo/{{ $processo->numero }}" target="_blank" class="form-control form-control-sm" style="color: blue;" readonly>
        {{ $processo->numero }}
    </a>
@else
    <input type="text" name="numero" id="numero" class="form-control form-control-sm" value="{{ $processo->numero }}" readonly>
@endif

            </div>
            <div class="col-md-3">
                <label class="col-form-label col-form-label-sm" for="status">Status:</label>
                <input type="text" name="numero" id="numero" class="form-control form-control-sm" value="{{ $processo->status }}" readonly>
            </div>
        </div>
        {{-- Linha 2 GRID --}}
        <div class="row">
            <div class="col-md-3">
                <label for="data" class="col-form-label col-form-label-sm">Criado em:</label>
                <input type="date" id="data" name="data" class="form-control form-control-sm" value="{{ $processo->data }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="prazo" class="col-form-label col-form-label-sm">Prazo:</label>
                <input type="date" id="prazo" name="prazo" class="form-control form-control-sm" value="{{ $processo->prazo }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="prazo" class="col-form-label col-form-label-sm">Concluído:</label>
                <input type="date" id="concluido" name="concluido" class="form-control form-control-sm" value="{{ $processo->concluido }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="col-form-label col-form-label-sm" for="usuario">Responsável:</label>
                <input type="text" id="concluido" name="concluido" class="form-control form-control-sm" value="{{ $processo->user->name }}" readonly>
            </div>
        </div>
    </div>
</div>
{{-- LISTAGEM DA MOVIMENTAÇÃO DO PROCESSO --}}
<h3>
    Movimentos
    <a href="{{route('processoMov.create', ['processo_id' => $processo->id] )}}" class="btn btn-sm btn-success">Novo Movimento</a>
</h3>

<div class="card">

    <div class="card-body">

            <table class="table table-sm table-hover" id="tabela" >
                <thead>
                <tr>
                    <th>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input class="form-control form-control-sm" id="data" type="text" placeholder="Data" style="font-weight: bold;">
                        </div>
                    </th>
                    <th>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input class="form-control form-control-sm" id="movimento" type="text" placeholder="Movimento" style="font-weight: bold;">
                        </div>
                    </th>
                    <th>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input class="form-control form-control-sm" id="usuario" type="text" placeholder="Usuário" style="font-weight: bold;">
                        </div>
                    </th>

                    <th>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-paper-plane"></i></span>
                            </div>
                            <input class="form-control form-control-sm" type="text" placeholder="AÇÕES" style="font-weight: bold; background-color: transparent;" disabled>
                        </div>
                    </th>
                </tr>
            </thead>
                @if ($processos_mov)
                <tbody>
                @foreach ($processos_mov as $processo_mov)
                <tr>
                    <td>{{ $processo_mov->data ? \Carbon\Carbon::parse($processo_mov->data)->format('d/m/Y') : '' }}</td>
                    <td>
                        {{ $processo_mov->descricao }}
                        @if ($processo_mov->anexo)

                            <a href="{{  url('processos/anexos/' . $processo_mov->anexo) }}" target="_blank">
                                <span style="margin-right: 20px;"><i class="fa fa-paperclip"></i></span>
                            </a>

                        @endif
                    </td>
                    <td>{{ explode(' ', $processo_mov->user->name)[0] }}</td>


                    <td>

                        <a href="{{ route('processoMov.edit', $processo_mov->id ) }}" class="btn btn-sm btn-primary">Editar</a>
                        @if($processo_mov->data == date('Y-m-d'))
                        <form class="d-inline" method="POST" action="{{ route('processoMov.destroy', $processo_mov->id) }}" onsubmit="return confirm('Tem certeza que deseja excluir este registro?')">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                        @endif
                    </td>


                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="9">
                        Não existem movimentos cadastrados!
                    </td>
                </tr>
                @endif
            </tbody>
            </table>

    </div>
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

