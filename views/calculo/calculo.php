<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use edwinhaq\simpleloading\SimpleLoading;

SimpleLoading::widget();

$this->title = 'Cálculo';

$script = <<< JS
    let inputs = $('#tabela-lancamento-horas input');

    $(document).ready(function(){
        $(".processar-horas").on("click", function(event) {
            event.preventDefault();
            $.ajax({
                url: '/calculo/processar-horas',
                type: 'post',
                dataType: 'json',
                data: inputs.serialize(),
                beforeSend: function(json)
                { 
                    SimpleLoading.start(); 
                },
                success: function (data) {
                    $.each(JSON.parse(data), function(index, value) {
                        $("#id_horas_trabalhadas_" + index).text(value["horas_trabalhadas"].toFixed(2));
                        $("#id_horas_diurnas_" + index).text(value["horas_diurnas"].toFixed(2));
                        $("#id_horas_noturnas_" + index).text(value["horas_noturnas"].toFixed(2));
                    });
                },
                complete: function(){
                    SimpleLoading.stop();
                }
            });
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
                    <li><a href="#tab1" data-toggle="tab">Pré-cálculo</a></li>
                    <li class="active"><a href="#tab2" data-toggle="tab">Lançamento de horas</a></li>
                    <li><a href="#tab3" data-toggle="tab">Resumo de horas</a></li>
                    <li><a href="#tab4" data-toggle="tab">Default 4</a></li>
                </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade" id="tab1">
                    <?= $this->render('_pre_calculo_review', [
                        'model' => $preCalculo,
                        'makeHidden' => true,
                        'form' => $form
                    ]) ?>
                </div>
                <div class="tab-pane fade in active" id="tab2">
                    <?= $this->render('_lancamento_horas', [
                        'horasParaLancamento' => $horasParaLancamento,
                        'anosTrabalhados' => $anosTrabalhados,
                        'mesPaginado' => $mesPaginado,
                        'anoPaginado' => $anoPaginado,
                        'form' => $form
                    ]) ?>
                </div>
                <div class="tab-pane fade" id="tab3">
                    <?= $this->render('_resumo_horas', [
                        'horasParaLancamento' => $horasParaLancamento,
                        'anosTrabalhados' => $anosTrabalhados,
                        'form' => $form
                    ]) ?>
                </div>
                <div class="tab-pane fade" id="tab4">Default 4</div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>