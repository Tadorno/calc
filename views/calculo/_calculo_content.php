<?php
    use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin([
            'id' => 'id-calculo-form',
            'layout' => 'horizontal'
        ]); ?>

<input type="hidden" id="processar-aba-apuracao" value="false"/>
<input type="hidden" id="processar-aba-resumo" value="false"/>

<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li ><a href="#tab-review" data-toggle="tab" data-tab="tab-review" class="main-tab">Pré-cálculo</a></li>
            <li class="active"><a href="#tab-lancamento-hora" data-toggle="tab" data-tab="tab-lancamento-hora" class="main-tab processar-horas">Lançamento de horas</a></li>
            <li ><a href="#tab-apuracao" data-toggle="tab" data-tab="tab-apuracao" class="main-tab manter-aba-apuracao">Apuração</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade" id="tab-review">
                <?= $this->render('pre-calculo-review/_pre_calculo_review', [
                    'model' => $preCalculo,
                    'makeHidden' => true,
                    'form' => $form
                ]) ?>
            </div>
            <div class="tab-pane fade in active" id="tab-lancamento-hora">
                <?= $this->render('lancamento-horas/_lancamento_horas', [
                    'horasParaLancamento' => $horasParaLancamento,
                    'anosTrabalhados' => $anosTrabalhados,
                    'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
                    'mesPaginado' => $mesPaginado,
                    'anoPaginado' => $anoPaginado,
                    'resumoHoras' => $resumoHoras,
                    'tabLancamento' => $tabLancamento
                ]) ?>
            </div>
            <div class="tab-pane fade" id="tab-apuracao">
                <?= $this->render('apuracao/_apuracao', [
                    'apuracao' => $apuracao,
                    'anosTrabalhados' => $anosTrabalhados
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>