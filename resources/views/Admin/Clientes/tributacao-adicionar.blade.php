@extends('adminlte::page')
@section('title', 'Tributação por Cliente')
@section('content_header')
<h3>Associar Tributação para o Cliente</h3>
@endsection
@section('content')

<form action="{{ route('tributacao.store') }}" method="POST" class="form-horizontal">
    @csrf
    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label" for="cliente_id">Cliente:*</label>
                    <select name="cliente_id" id="cliente_id" class="form-control" required>
                        <option value="">Selecione</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-5">
                    <label class="col-form-label" for="tributacao">Tributação:* </label>
                    <select name="tipo" id="tributacao" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="Lucro Real Anual" @if(old('tipo') == 'Lucro Real Anual') selected @endif>Lucro Real Anual</option>
                        <option value="Lucro Real Trimestral" @if(old('tipo') == 'Lucro Real Trimestral') selected @endif>Lucro Real Trimestral</option>
                        <option value="Lucro Presumido" @if(old('tipo') == 'Lucro Presumido') selected @endif>Lucro Presumido</option>
                        <option value="Simples Nacional" @if(old('tipo') == 'Simples Nacional') selected @endif>Simples Nacional</option>
                        <option value="Pessoa Física" @if(old('tipo') == 'Pessoa Física') selected @endif>Pessoa Física</option>
                    </select>
                    @error('tipo')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="data" class="col-form-label">A partir de:* </label>
                    <input type="date" id="data" name="data" class="form-control @error('data') is-invalid @enderror" value="{{ old('data') }}" required>
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
                    <input type="submit" value="Cadastrar" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
@endsection
