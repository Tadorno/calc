<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use edwinhaq\simpleloading\SimpleLoading;

SimpleLoading::widget();

$this->title = 'Cálculo';

$script = <<< JS

    $(document).ready(function(){
        $(".processar-horas").on("click", function(event) {
            event.preventDefault();

            var input = $('#tabela-lancamento-horas input').serializeArray();
            
            input.push({name: "anoPaginado", value: $("#anoPaginado").val()});//Ano atual
            input.push({name: "mesPaginado", value: $("#mesPaginado").val()});//Mes Atual

            $.ajax({
                url: '/calculo/processar-horas',
                type: 'post',
                data: input,
                beforeSend: function()
                { 
                    SimpleLoading.start(); 
                },
                success: function (data) {
                    $("#tab-resumo-hora").html(data);    
                },
                complete: function(){
                    SimpleLoading.stop();
                }
            });
        });

        $('#tab-lancamento-hora').on('click', '.mudar-ano', function(event) {
            mudarAba($(this).data("ano"), null);
        });

        $('#tab-lancamento-hora').on('click', '.mudar-mes', function(event) {
            mudarAba($(this).data("ano"), $(this).data("mes"));
        });

        function mudarAba(ano, mes){

            var input = $('#tabela-lancamento-horas input').serializeArray();
            
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

        $('#tab-resumo-hora').on('click', '.treeview-item', function(event) {
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

    <?php $form = ActiveForm::begin([
        'id' => 'id-calculo-form',
        'layout' => 'horizontal'
    ]); ?>

    <button value="Processar Horas" class="processar-horas btn btn-primary"><span class="glyphicon glyphicon-cog"></span> Processar Horas</button>

    <div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
        <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li><a href="#tab-review" data-toggle="tab">Pré-cálculo</a></li>
                    <li class="active"><a href="#tab-lancamento-hora" data-toggle="tab">Lançamento de horas</a></li>
                    <li><a href="#tab-resumo-hora" data-toggle="tab">Resumo de horas</a></li>
                    
                </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade" id="tab-review">
                    <?= $this->render('_pre_calculo_review', [
                        'model' => $preCalculo,
                        'makeHidden' => true,
                        'form' => $form
                    ]) ?>
                </div>
                <div class="tab-pane fade in active" id="tab-lancamento-hora">
                    <?= $this->render('_lancamento_horas', [
                        'horasParaLancamento' => $horasParaLancamento,
                        'anosTrabalhados' => $anosTrabalhados,
                        'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
                        'mesPaginado' => $mesPaginado,
                        'anoPaginado' => $anoPaginado
                    ]) ?>
                </div>
                <div class="tab-pane fade" id="tab-resumo-hora">
                    <?= $this->render('_resumo_horas') ?>
                </div>
                
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>