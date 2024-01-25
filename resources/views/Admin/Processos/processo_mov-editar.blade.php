@extends('adminlte::page')
@section('title', 'Alterar Movimento do Processo')
@section('content_header')
<h3>Alterar Movimento do Processo</h3>
@endsection
@section('content')
<form action="{{ route('processoMov.update', $processo_mov->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <input type="hidden" name="processo_id" value="{{ $processo_mov->processo_id }}">
    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">
                <div class="col-md-2">
                    <input type="hidden" name="data" value="{{ $processo_mov->data }}">
                    <label for="data" class="col-form-label">Data*:</label>
                    <input type="date" class="form-control @error('data') is-invalid @enderror" value="{{ $processo_mov->data }}" required disabled>
                    @error('data')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="col-form-label" for="descricao">Movimento:* </label>
                    <input type="text" name="descricao" id="descricao" class="form-control @error('descricao') is-invalid @enderror" value="{{ $processo_mov->descricao }}" required>
                    @error('descricao')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>


                <div class="col-md-1">
                    <label class="col-form-label">Anexo Atual:</label>
                    @if ($processo_mov->anexo)
                    <a href="{{ url('processos/anexos/' . $processo_mov->anexo) }}" target="_blank"><span style="margin-right: 20px;"><i class="fa fa-paperclip"></i></span></a>
                    @else
                    <div class="text-danger"> <i class="icon fas fa-ban"></i></div>
                    @endif
                </div>


                <div class="col-md-2">
                    <label class="col-form-label" for="anexo" class="form-label">Substituir o anexo (apenas '.pdf'):</label>
                    <input class="form-control" name="anexo" type="file" id="anexo" >
                    @error('anexo')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="col-form-label" for="usuario">Responsável:*</label>
                    <select name="user_id" id="usuario" class="form-control" required>
                        <option value="">Selecione</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $processo_mov->user_id == $user->id ? 'selected' : '' }}>
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
