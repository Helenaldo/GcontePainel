$(function(){
    $("#tabela input").keyup(function(){
        var columnIndex = $(this).closest('th').index();
        var selector = "#tabela td:nth-child(" + (columnIndex + 1) + ")";
        var valor = $(this).val().toUpperCase();

        $("#tabela tbody tr").show();

        $(selector).each(function(){
            if($(this).text().toUpperCase().indexOf(valor) < 0){
                $(this).parent().hide();
            }
        });
    });

    $("#tabela input").blur(function(){
        $(this).val("");
    });
});



// $(function(){
//     $("#tabela input").keyup(function(){
//         var index = $(this).parent().index();
//         var nth = "#tabela td:nth-child("+(index+1).toString()+")";
//         var valor = $(this).val().toUpperCase();
//         $("#tabela tbody tr").show();
//         $(nth).each(function(){
//             if($(this).text().toUpperCase().indexOf(valor) < 0){
//                 $(this).parent().hide();
//             }
//         });
//     });

//     $("#tabela input").blur(function(){
//         $(this).val("");
//     });
// });
