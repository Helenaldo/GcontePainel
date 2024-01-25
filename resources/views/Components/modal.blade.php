<!-- Botão para acionar modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalExemplo">
    {{$btn_abrir_modal}}
  </button> --}}

  <!-- Modal -->
  <div class="modal fade" id="{{$nome_modal}}" tabindex="-1" role="dialog" aria-labelledby="{{$id_modal_label}}" aria-hidden="true">    <div class="modal-dialog {{$tamanho}}" role="document">
        {{-- <div class="modal-dialog modal-xl" role="document"> --}}
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="{{$id_modal_label}}">{{$titulo_modal}}</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


            {{$slot}}



        </div>

      </div>
    </div>
  </div>
</div>


