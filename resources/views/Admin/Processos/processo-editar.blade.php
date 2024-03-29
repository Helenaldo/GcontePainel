@extends('adminlte::page')
@section('title', 'Novo Processo')
@section('content_header')
<h3>Editar Processo</h3>

@endsection
@section('content')
<form action="{{ route('processo.update', ['processo' => $processo->id]) }}" method="POST" class="form-horizontal">
    @method('PUT')
    @csrf
    <input type="hidden" name="cliente_id" value="{{ $processo->cliente_id }}">
    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">
                <div class="col-md-4">
                    <label class="col-form-label" for="cliente">Cliente:*</label>
                    <input type="text" name="cliente" id="cliente" class="form-control @error('cliente_id') is-invalid @enderror" value="{{ $processo->cliente->nome }}" required disabled>
                    @error('cliente')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="col-form-label" for="titulo">Título:* </label>
                    <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ $processo->titulo }}" required>
                    @error('titulo')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="col-form-label" for="titulo">Número:</label>
                    <input type="text" name="numero" id="numero" class="form-control @error('numero') is-invalid @enderror" value="{{ $processo->numero }}">
                    @error('numero')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="col-form-label" for="status">Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Em andamento" @if($processo->status == 'Em andamento') selected @endif>Em andamento</option>
                        <option value="Atrasado" @if($processo->status == 'Atrasado') selected @endif>Atrasado</option>
                        <option value="Concluido" @if($processo->status == 'Concluido') selected @endif>Concluído</option>
                    </select>
                    @error('tipo')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

            </div>
            {{-- Linha 2 GRID --}}
            <div class="row">
                <div class="col-md-3">
                    <label for="data" class="col-form-label">Criado em:</label>
                    <input type="date" id="data" name="data" class="form-control @error('data') is-invalid @enderror" value="{{ $processo->data }}">
                    @error('data')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="prazo" class="col-form-label">Prazo:</label>
                    <input type="date" id="prazo" name="prazo" class="form-control @error('prazo') is-invalid @enderror" value="{{ $processo->prazo }}">
                    @error('prazo')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="prazo" class="col-form-label">Concluído:</label>
                    <input type="date" id="concluido" name="concluido" class="form-control @error('concluido') is-invalid @enderror" value="{{ $processo->concluido }}">
                    @error('concluido')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="col-form-label" for="usuario">Responsável:*</label>
                    <select name="user_id" id="usuario" class="form-control" required>
                        <option value="">Selecione</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $processo->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
            </div>


        </div>
        <div class="card-footer">
            {{-- Botões --}}
            <div class="row" >
                <div class="col-md-12 text-right" >
                    <a href="{{route('processo.index')}}" type="button" class="btn btn-secondary">Fechar</a>
                    <input type="submit" value="Alterar" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/concluido.js" type="text/javascript"></script>
@endsection
