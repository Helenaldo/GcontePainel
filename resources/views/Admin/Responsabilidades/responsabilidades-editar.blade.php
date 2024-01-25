@extends('adminlte::page')
@section('title', 'Alterar Responsabilidades')
@section('content_header')
<h3>Alterar Responsabilidades</h3>
@endsection
@section('content')
<form action="{{ route('responsabilidades.update', ['responsabilidade' => $responsabilidade->id]) }}" method="POST" class="form-horizontal">
    @method('PUT')
    @csrf
    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">
                <div class="col-md-4">
                    <label for="data" class="col-form-label">Data*:</label>
                    <input type="date" id="data" name="data" class="form-control @error('data') is-invalid @enderror" value="{{ $responsabilidade->data }}" required>
                    @error('data')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-8">
                    <label class="col-form-label" for="cliente_id">Cliente:*</label>
                    <select name="cliente_id" id="cliente_id" class="form-control" required>
                        <option value="">Selecione</option>
                        @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ $responsabilidade->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nome }}
                        </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
            </div>
            {{-- {{dd($responsabilidade->contabil)}} --}}
            {{-- Linha 2 GRID --}}
                <div class="row">
                <div class="col-md-3">
                    <label class="col-form-label" for="usuario">Contábil:</label>
                    <select name="contabil" id="contabil" class="form-control">
                        <option value="">Selecione</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{$responsabilidade->contabil == $user->id ? 'selected' : ''}}>
                        {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('contabil')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="col-form-label" for="usuario">Pessoal:</label>
                    <select name="pessoal" id="pessoal" class="form-control">
                        <option value="">Selecione</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{$responsabilidade->pessoal == $user->id ? 'selected' : ''}}>
                        {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('pessoal')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="col-form-label" for="usuario">Fiscal:</label>
                    <select name="fiscal" id="fiscal" class="form-control">
                        <option value="">Selecione</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{$responsabilidade->fiscal == $user->id ? 'selected' : ''}}>
                        {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('fiscal')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="col-form-label" for="usuario">Paralegal:</label>
                    <select name="paralegal" id="paralegal" class="form-control">
                        <option value="">Selecione</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{$responsabilidade->paralegal == $user->id ? 'selected' : ''}}>
                        {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('paralegal')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

            </div>
        </div>
        <div class="card-footer">
            {{-- Botões --}}
            <div class="row" >
                <div class="col-md-12 text-right" >
                    <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary">Fechar</a>
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
