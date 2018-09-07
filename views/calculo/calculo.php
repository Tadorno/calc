<?php

use yii\helpers\Html;
use edwinhaq\simpleloading\SimpleLoading;

SimpleLoading::widget();

$this->title = 'Cálculo';

$script = <<< JS

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

        $('#calculo-content').on('click', '.treeview-item', function(event) {
            
            nodeid = $(this).data('nodeid');
            nodesinal = $(this).data('nodesinal');

            if(nodesinal === "+"){
                $(this).data('nodesinal', '-');
                $(".span_" + nodeid).removeClass("glyphicon-plus");
                $(".span_" + nodeid).addClass("glyphicon-minus");
                $("#treeview ." + nodeid).removeClass("hide");
            }else{
                $(this).data('nodesinal', '+');
                $(".span_" + nodeid).addClass("glyphicon-plus");
                $(".span_" + nodeid).removeClass("glyphicon-minus");
                $("#treeview ." + nodeid).addClass("hide");
            }
            
        });
    }); 
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>
<div class="calculo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="calculo-content">

        <?= $this->render('_calculo_content', [
            'horasParaLancamento' => $horasParaLancamento,
            'anosTrabalhados' => $anosTrabalhados,
            'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
            'mesPaginado' => $mesPaginado,
            'anoPaginado' => $anoPaginado,
            'preCalculo' => $preCalculo,
            'resumoHoras' => $resumoHoras,
            'apuracao' => $apuracao,
            'mainTab' => $mainTab,
            'tabLancamento' => $tabLancamento
        ]) ?>

    </div>
   
</div>