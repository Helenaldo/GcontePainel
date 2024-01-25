@extends('adminlte::page')

@section('title', 'Painel')

@section('content_header')
    <h3>Página para Testes</h3>
@endsection

@section('content')
@component('Components.modal')
@slot('btn_abrir_modal') Abrir Modal @endslot
@slot('titulo_modal') Teste de Motal Componentizado @endslot
@slot('tamanho') modal-xl @endslot
@slot('btn_nome') Salvandoooo @endslot




<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="pills-clientes-tab" data-toggle="pill" href="#pills-clientes" role="tab" aria-controls="pills-clientes" aria-selected="true">Clientes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="pills-estabelecimentos-tab" data-toggle="pill" href="#pills-estabelecimentos" role="tab" aria-controls="pills-estabelecimentos" aria-selected="false">Estabelecimentos</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="pills-tributacao-tab" data-toggle="pill" href="#pills-tributacao" role="tab" aria-controls="pills-tributacao" aria-selected="false">Tributação</a>
    </li>
  </ul>
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-clientes" role="tabpanel" aria-labelledby="pills-clientes-tab">...</div>
    <div class="tab-pane fade" id="pills-estabelecimentos" role="tabpanel" aria-labelledby="pills-estabelecimentos-tab">...</div>
    <div class="tab-pane fade" id="pills-tributacao" role="tabpanel" aria-labelledby="pills-tributacao-tab">...</div>
  </div>







@endcomponent
@endsection


{{--
@section('css')
para css específicos
@endsection
--}}

{{--
@section('js')
    <script>alert('rodando')</script>
@endsection
--}}
