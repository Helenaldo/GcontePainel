@extends('adminlte::page')
@section('title', 'Alterar Tributação')
@section('content_header')
<h3>Alterar Tributação</h3>
@endsection
@section('content')
<form action="{{ route('tributacao.update', ['tributacao' => $tributacao->id]) }}" method="POST" class="form-horizontal">
    @method('PUT')
    @csrf
    <input type="hidden" name="cliente_id" value="{{$tributacao->cliente_id}}">
    {{-- Linha 1 GRID --}}
    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label" for="cliente">Cliente:*</label>
                    <input type="text" name="cliente" id="cliente" class="form-control @error('cliente') is-invalid @enderror" value="{{ $tributacao->cliente->nome }}" required disabled>
                    @error('cliente')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-5">
                    <label class="col-form-label" for="tributacao">Tributação:* </label>
                    <select name="tipo" id="tributacao" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="Lucro Real Anual" @if($tributacao->tipo == 'Lucro Real Anual') selected @endif>Lucro Real Anual</option>
                        <option value="Lucro Real Trimestral" @if($tributacao->tipo == 'Lucro Real Trimestral') selected @endif>Lucro Real Trimestral</option>
                        <option value="Lucro Presumido" @if($tributacao->tipo == 'Lucro Presumido') selected @endif>Lucro Presumido</option>
                        <option value="Simples Nacional" @if($tributacao->tipo == 'Simples Nacional') selected @endif>Simples Nacional</option>
                        <option value="Pessoa Física" @if($tributacao->tipo == 'Pessoa Física') selected @endif>Pessoa Física</option>
                    </select>
                    @error('tipo')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="data" class="col-form-label">A partir de:* </label>
                    <input type="date" id="data" name="data" class="form-control @error('data') is-invalid @enderror" value="{{ $tributacao->data }}" required>
                    @error('data')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer">
            {{-- Botões --}}
            <div class="row" >
                <div class="col-md-12 text-right" >
                    <a href="{{route('tributacao.index')}}" type="button" class="btn btn-secondary">Fechar</a>
                    <input type="submit" value="Alterar" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
@endsection
