async function carregarCidades(cidade) {
    //Consultar apenas quando tiver 3 caracteres
    if (cidade.length > 2){

        //Fazer a requisição para o Controller buscar no banco de dados
        const dados = await fetch('http://localhost:8000/clientes/buscar-cidade?cidade=' + cidade);

        // Ler os valores retornado do controller
        const resposta = await dados.json();

        //Abrir a lista de cidades
        var conteudoHTML = "<ul class='list-group'>";

        if(resposta['status']) {
            // Percorrer a lista de cidades retornado do BD/Controller
            for(i = 0; i < resposta['dados'].length; i++) {
                conteudoHTML +=
                "<li class='list-group-item list-group-itemaction' style='cursor: pointer;' onclick='getIdCidade(" + resposta['dados'][i].id + ","  + JSON.stringify(resposta['dados'][i].municipio + " - " + resposta['dados'][i].UF) + ")' >"
                + resposta['dados'][i].municipio
                +' - '
                + resposta['dados'][i].UF
                + "</li>";
            }
        } else {
            // Criar o item da lista com o erro retornado do controller
            conteudoHTML += "<li class='list-group-item disabled'>" + resposta['message'] + "</li>";
        }

        // Fechar a lista de cidades
        conteudoHTML += "</ul>"

        // Enviar para a página a lista de cidades
        document.getElementById('resultado-pesquisa').innerHTML = conteudoHTML;
    } else {
        //Fechar a listra de cidades ou o erro
        document.getElementById("resultado-pesquisa").innerHTML = "";
    }
}

function getIdCidade(id_cidade, cidade) {
    //Enviar o nome da cidade para o campo cidade do formulário
    document.getElementById("cidade_id").value = cidade;

    //Enviar o id da cidade para um campo oculto
    document.getElementById("id_cidade").value = id_cidade;

    //Fechar a listra de cidades ou o erro
    document.getElementById("resultado-pesquisa").innerHTML = "";

}
