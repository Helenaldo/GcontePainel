@extends('adminlte::page')
@section('title', 'Adicionar Cliente')
@section('content_header')
<h3>Adicionar Contatos</h3>
@endsection
@section('content')
<form action="{{ route('contatos.store') }}" method="POST" class="form-horizontal">
    @csrf
    <div class="card">
        <div class="card-body">
            {{-- Linha 1 GRID --}}
            <div class="row">
                <div class="col-md-3">
                    <label class="col-form-label" for="cliente_id">Cliente:*</label>
                    <select name="cliente_id" id="cliente_id" class="form-control select2" required>
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
                <div class="col-md-4">
                    <label class="col-form-label" id="nome_contato" for="nome_contato">Nome:* </label>
                    <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
                    @error('nome')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="email" class="col-form-label">E-mail:* </label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="col-form-label" id="nome_contato" for="telefone">Telefone: </label>
                    <input type="text" name="telefone" id="telefone" class="form-control @error('telefone') is-invalid @enderror" value="{{ old('telefone') }}" required>
                    @error('telefone')
                    <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
                    @enderror
                </div>
            </div>

        </div>
        <div class="card-footer">
            {{-- Botões --}}
            <div class="row" >
                <div class="col-md-12 text-right" >
                    <a href="{{route('contatos.index')}}" type="button" class="btn btn-secondary">Fechar</a>
                    <input type="submit" value="Cadastrar" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="/assets/js/mascaras.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
