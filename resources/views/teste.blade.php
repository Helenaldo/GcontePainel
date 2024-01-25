@extends('adminlte::page')

@section('title', 'Painel')

@section('content_header')
    <h3>Página para Testes</h3>
@endsection

@section('content')
@component('Components.modal')
@slot('nome_modal') Abrir Modal @endslot
@slot('titulo_modal') Teste de Motal Componentizado @endslot
@slot('tamanho') modal-xl @endslot
@slot('btn_nome') Salvandoooo @endslot




        <form action="{{ route('clientes.store') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="container">
                {{-- Linha 1 GRID --}}
                <div class="row">
                  <div class="col-md-2">
                    <label class="col-form-label" for="cpf_cnpj">TIPO:*</label>
                    <select name="tipo_identificacao" id="tipo_identificacao" class="form-control">
                        <option value="">Selecione</option>
                        <option value="cnpj">CNPJ</option>
                        <option value="cpf">CPF</option>
                    </select>
                  </div>

                  <div class="col-md-2">
                    <label class="col-form-label" id="cpfCnpjLabel">CPF/CNPJ:* </label>
                    <input type="text" name="cpf_cnpj" class="form-control @error('cpf_cnpj') is-invalid @enderror" value="{{ old('cpf_cnpj')}}" >
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
            </div>
        </form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/assets/js/carregar-cidades.js"></script>
<script>
$(document).ready(function() {
    // Detectar a mudança na seleção de 'tipo_identificacao'
    $('#tipo_identificacao').change(function() {
        var selectedOption = $(this).val();
        var label = 'CPF/CNPJ:*';

        if (selectedOption === 'cpf') {
            label = 'CPF:*';
        } else if (selectedOption === 'cnpj') {
            label = 'CNPJ:*';
        }

        // Atualizar o texto do rótulo com base na seleção
        $('#cpfCnpjLabel').text(label);
    });
});

//Adicionar o Select2
$(document).ready(function() {
    $('#cidade_id').select2();
});



</script>



@endcomponent
@endsection



{{-- @section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
@endsection --}}



{{-- @section('js')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
@endsection --}}
