$(document).ready(function(){
    $('#calculo-content').on('click', '.mudar-ano', function(event) {
        $("#tabLancamento").val($(this).data('tab'));  

        if($('#anoPaginado').val() !== $(this).data("ano")){
            mudarAba($(this).data("ano"), null);
        }
    });

    $('#calculo-content').on('click', '.mudar-mes', function(event) {
        if($('#mesPaginado').val() != $(this).data("mes")){
            mudarAba($(this).data("ano"), $(this).data("mes"));
        }
    });

    $('#calculo-content').on('change', '.altera-calculo', function(event) {
        $("#processar").val(true);
    });

    function mudarAba(ano, mes){

        var input = $('#tabela-lancamento-horas input').serializeArray();
        
        input.push({name: "tabLancamento", value: $("#tabLancamento").val()});//Aba de lancamento
        input.push({name: "anoPaginado", value: $("#anoPaginado").val()});//Ano atual
        input.push({name: "mesPaginado", value: $("#mesPaginado").val()});//Mes Atual
        input.push({name: "ano", value: ano});//Novo Ano
        input.push({name: "mes", value: mes});//Novo Mes
        
        $.ajax({
            url: '/calculo/mudar-aba-lancamento-horas',
            type: 'post',
            data: input,
            beforeSend: function()
            { 
            SimpleLoading.start(); 
            },
            success: function (data) {
            $("#tab-lancamento-hora").html(data);
            },
            complete: function(){
                $("#tab-lancamento-hora .hora").inputmask("hh:mm");
                SimpleLoading.stop();
            }
        });
    }
});