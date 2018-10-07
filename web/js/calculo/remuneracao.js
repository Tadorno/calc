$(document).ready(function(){
    $('#calculo-content').on('click', '.mudar-ano-remuneracao', function(event) {
        if($('#remuneracaoAnoPaginado').val() !== $(this).data("ano")){
            mudarAba($(this).data("ano"));
        }
    });

    function mudarAba(ano){
        var input = $('#tabela-remuneracao input').serializeArray();

        input.push({name: "anoPaginado", value: $("#remuneracaoAnoPaginado").val()});//Ano atual
        input.push({name: "ano", value: ano});//Novo Ano
    
        $.ajax({
            url: '/calculo/mudar-aba-remuneracao',
            type: 'post',
            data: input,
            beforeSend: function()
            { 
                SimpleLoading.start(); 
            },
            success: function (data) {
                $("#tab-remuneracao").html(data);
            },
            complete: function(){
                $("#tab-remuneracao .decimal-2").inputmask({alias: 'numeric', 
                       allowMinus: false,  
                       digits: 2});
                SimpleLoading.stop();
            }
        });
    }
});