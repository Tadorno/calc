$(document).ready(function(){
    $('#calculo-content').on('click', '.processar-horas', function(event) {
        event.preventDefault();

        if($(this).data('tab') !== undefined){
            $("#main-tab").val($(this).data('tab'));
        }

        if($(this).data('tab-lancamento') !== undefined){
            $("#tabLancamento").val($(this).data('tab-lancamento')); 
        }

        if($('#processar').val() == "true"){
            var input = $('#id-calculo-form').serializeArray();

            $.ajax({
                url: '/calculo/processar-horas',
                type: 'post',
                data: input,
                beforeSend: function()
                { 
                    SimpleLoading.start(); 
                },
                success: function (data) {
                    $("#calculo-content").html(data);    
                },
                complete: function(){
                    $("#tab-lancamento-hora .hora").inputmask("hh:mm");
                    SimpleLoading.stop();
                }
            });
        }
    });

    $('#calculo-content').on('click', '.main-tab', function(event) {       
        $("#main-tab").val($(this).data('tab'));      
    });
}); 