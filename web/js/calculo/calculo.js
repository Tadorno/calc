$(document).ready(function(){
    $('#calculo-content').on('click', '.manter-aba-apuracao', function(event) {
        event.preventDefault();

        if($('#processar-aba-apuracao').val() == "true"){
            var input = $('#id-calculo-form').serializeArray();

            $.ajax({
                url: '/calculo/manter-aba-apuracao',
                type: 'post',
                data: input,
                beforeSend: function()
                { 
                    SimpleLoading.start(); 
                },
                success: function (data) {
                    $("#tab-apuracao").html(data);
                    $('#processar-aba-apuracao').val(false) 
                },
                complete: function(){
                    SimpleLoading.stop();
                }
            });
        }
    });

    $('#calculo-content').on('click', '.main-tab', function(event) {       
        $("#main-tab").val($(this).data('tab')); 
    });
}); 