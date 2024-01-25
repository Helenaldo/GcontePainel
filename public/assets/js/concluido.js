$(document).ready(function() {
    // Ao carregar a página, verifique o valor inicial do campo "status"
    toggleConcluidoField();

    // Adicione um ouvinte de mudança ao campo "status"
    $('#status').change(function() {
        // Ao alterar o valor do campo "status", chame a função para atualizar o estado do campo "concluido"
        toggleConcluidoField();
    });

    function toggleConcluidoField() {
        // Obtenha o valor atual do campo "status"
        var statusValue = $('#status').val();

        // Se o valor for "Concluido", habilite o campo "concluido", caso contrário, desabilite-o
        if (statusValue === 'Concluido') {
            $('#concluido').prop('disabled', false);
            $('#concluido').prop('required', true);
        } else {
            $('#concluido').prop('disabled', true);
            $('#concluido').prop('required', false);
        }
    }
});

