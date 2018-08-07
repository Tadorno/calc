<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Cálculo';

$script = <<< JS
    let inputs = $('#tabela-lancamento-horas input');
    $(document).ready(function(){
        $(".processar-horas").on("click", function() {
            $.ajax({
                url: '/calculo/processar-horas',
                type: 'post',
                data: inputs.serialize(),
                success: function (data) {
                    alert(data);
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

    <div class="panel with-nav-tabs panel-default">
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
                        'horasLancadas' => $horasLancadas,
                        'anosTrabalhados' => $anosTrabalhados,
                        'form' => $form
                    ]) ?>
                </div>
                <div class="tab-pane fade" id="tab3">Default 3</div>
                <div class="tab-pane fade" id="tab4">Default 4</div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>