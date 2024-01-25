@extends('adminlte::page')

@section('title', 'Adicionar Cliente')

@section('content_header')
    <h3>Adicionar Cliente</h3>
@endsection

@section('content')
<form action="{{ route('clientes.store') }}" method="POST" class="form-horizontal">
    @csrf
    <div class="card">
        <div class="card-body">
                {{-- Linha 1 GRID --}}
    <div class="row">
        <div class="col-md-2">
            <label class="col-form-label" for="tipo_identificacao">TIPO:*</label>
            <select name="tipo_identificacao" id="tipo_identificacao" class="form-control">
                <option value="">Selecione</option>
                <option value="cnpj" @if(old('tipo_identificacao') == 'cnpj') selected @endif>CNPJ</option>
                <option value="cpf" @if(old('tipo_identificacao') == 'cpf') selected @endif>CPF</option>
            </select>
            @error('tipo_identificacao')
            <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
            @enderror
        </div>
        <div class="col-md-2">
            <label class="col-form-label" id="cpfCnpjLabel" for="cpf_cnpj">CPF/CNPJ:* </label>
            <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control @error('cpf_cnpj') is-invalid @enderror" value="{{ old('cpf_cnpj')}}" >
            @error('cpf_cnpj')
            <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
            @enderror
        </div>
        <div class="col-md-8">
            <label for="nome" class="col-form-label">Nome:* </label>
            <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome')}}">
            @error('nome')
            <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
            @enderror
        </div>
    </div>
    {{-- Linha 2 GRID --}}
    <div class="row">
        <div class="col-md-4">
            <label class="col-form-label" for="fantasia">Fantasia: </label>
            <input type="text" name="fantasia" id="fantasia" class="form-control" value="{{ old('fantasia')}}">
            @error('fantasia')
            <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
            @enderror
        </div>
        <div class="col-md-2">
            <label class="col-form-label" for="cep">CEP: </label>
            <input type="text" name="cep" id="cep" class="form-control" value="{{ old('cep')}}">
            @error('cep')
            <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="col-form-label" for="logradouro">Logradouro: </label>
            <input type="text" name="logradouro" id="logradouro" class="form-control" value="{{ old('logradouro')}}">
            @error('logradouro')
            <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
            @enderror
        </div>
    </div>
    {{-- Linha 3 GRID --}}
    <div class="row">
        <div class="col-md-2">
            <label class="col-form-label" for="numero">Número: </label>
            <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero')}}">
            @error('numero')
            <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="bairro">Bairro: </label>
            <input type="text" name="bairro" id="bairro" class="form-control" value="{{ old('bairro')}}">
            @error('bairro')
            <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="complemento">Complemento: </label>
            <input type="text" name="complemento" id="complemento" class="form-control" value="{{ old('complemento')}}">
        </div>
        <div class="col-md-4">
            <label class="col-form-label" for="cidade">Cidade-UF: </label>
            <select
                name="cidade_id"
                id="cidade_id"
                class="form-control select2 @error('cidade_id') is-invalid @enderror"
                style="width: 100%;"
                >
                <option value="">Selecione a cidade</option>
                @foreach ($cidades as $cidade)
                <option
                value="{{ $cidade->id }}"
                @if(old('cidade_id') == '{{ $cidade->id }}') selected @endif
                >{{$cidade->municipio . ' - ' . $cidade->UF}}
                </option>
                @endforeach
            </select>
            @error('cidade_id')
            <div class="text-danger"> <i class="icon fas fa-ban"></i> {{$message}}</div>
            @enderror
        </div>
    </div>
    {{-- Linha 4 GRID --}}
    <div class="row">
        <div class="col-md-3">
            <label class="col-form-label" for="data_entrada">Cliente desde: </label>
            <input type="date" name="data_entrada" id="data_entrada" class="form-control" value="{{ old('data_entrada')}}">
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="data_saida">Fim de contrato: </label>

            <input type="date" name="data_saida" id="data_saida" class="form-control" value="{{ old('data_saida')}}" {{ $loggedUser->perfil != 'Administrador' ? 'disabled' : '' }}>

        </div>
        <div class="col-md-2">
            <label class="col-form-label" for="matriz_filial">Estabelecimento:</label>
            <select name="tipo" id="matriz_filial" class="form-control">
                <option value="">Selecione</option>
                <option value="matriz" @if(old('matriz_filial') == 'matriz') selected @endif>Matriz</option>
                <option value="filial" @if(old('matriz_filial') == 'filial') selected @endif>Filial</option>
            </select>
        </div>
    </div>
        </div>
        <div class="card-footer">
            {{-- Botões --}}
           <div class="row" >
               <div class="col-md-12 text-right" >
                   <a href="{{route('clientes.index')}}" type="button" class="btn btn-secondary">Fechar</a>
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

@section('css')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    .select2-selection__rendered {
        line-height: 32px !important;
    }
    .select2-container .select2-selection--single {
        height: 36px !important;
    }
    .select2-selection__arrow {
        height: 35px !important;
    }
    </style>
@endsection

