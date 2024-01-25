@extends('adminlte::page')
@section('title', 'Movimentar Processo')
@section('content_header')
<h3>Novo Movimento do Processo</h3>
@endsection
@section('content')
<form class="form-horizontal" action="{{ route('processoMov.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="processo_id" value="{{ $processo_id }}">
    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">
                <div class="col-md-2">
                    <label for="data" class="col-form-label">Data*:</label>
                    <input type="date" id="data" name="data" class="form-control @error('data') is-invalid @enderror" value="{{ old('data', now()->toDateString()) }}" required>
                    @error('data')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="col-form-label" for="descricao">Movimento:* </label>
                    <input type="text" name="descricao" id="descricao" class="form-control @error('descricao') is-invalid @enderror" value="{{ old('descricao') }}" required>
                    @error('descricao')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>


                <div class="col-md-3">
                    <label class="col-form-label" for="anexo" class="form-label">Anexo (apenas '.pdf'):</label>
                    <input class="form-control" name="anexo" type="file" id="anexo">
                    @error('anexo')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="col-form-label" for="usuario">Responsável:*</label>
                    <select name="user_id" id="usuario" class="form-control" required>
                        <option value="">Selecione</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $usuarioLogado->id == $user->id ? 'selected' : '' }}>
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
                    <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary">Fechar</a>
                    <input type="submit" value="Cadastrar" class="btn btn-success">
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
