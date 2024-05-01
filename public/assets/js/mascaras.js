$(document).ready(function() {
    // Função para atualizar o rótulo e habilitar/desabilitar o campo "cpf_cnpj"
    function atualizarLabelEInput() {
        var selectedOption = $('#tipo_identificacao').val();
        var label = 'CPF/CNPJ:*';

        if (selectedOption === 'cpf') {
            label = 'CPF:*';
            $("#cpf_cnpj").mask("000.000.000-00");
            // Habilitar o campo "cpf_cnpj" se a opção for "CPF"
            $('#cpf_cnpj').prop('disabled', false);
            $('#matriz_filial').prop('disabled', true);
        } else if (selectedOption === 'cnpj') {
            label = 'CNPJ:*';
            $("#cpf_cnpj").mask("00.000.000/0000-00");
            // Habilitar o campo "cpf_cnpj" se a opção for "CNPJ"
            $('#cpf_cnpj').prop('disabled', false);
            $('#matriz_filial').prop('disabled', false);
        } else {
            // Desabilitar o campo "cpf_cnpj" para qualquer outra opção
            $('#cpf_cnpj').prop('disabled', true);
            $('#matriz_filial').prop('disabled', false);
        }

        // Atualizar o texto do rótulo com base na seleção
        $('#cpfCnpjLabel').text(label);
    }

    // Função para aplicar a máscara ao telefone em tempo real
    function aplicarMascaraTelefone() {
        var telefone = $('#telefone');

        telefone.unbind('input'); // Remover o evento input antes de reaplicar

        telefone.mask(function (val) {
            // Remover não dígitos
            var digits = val.replace(/\D/g, '');

            // Determinar a máscara com base na quantidade de dígitos
            return digits.length === 11 ? "(00) 0 0000-0000" : "(00) 0000-0000";
        });

        // Aplicar a máscara ao campo de telefone
        telefone.on('input', aplicarMascaraTelefone);
    }

    // Executar as funções ao carregar a página
    atualizarLabelEInput();
    aplicarMascaraTelefone();

    // Detectar a mudança na seleção de 'tipo_identificacao'
    $('#tipo_identificacao').change(function() {
        atualizarLabelEInput();
    });

    // Detectar a mudança no campo de telefone
    $('#telefone').on('input', aplicarMascaraTelefone);

    // Aplicar máscara ao CEP
    $("#cep").mask("00.000-000");
});
