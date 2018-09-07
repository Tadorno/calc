<?php
    use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin([
            'id' => 'id-calculo-form',
            'layout' => 'horizontal'
        ]); ?>

<input type="hidden" id="processar" value="false"/>
<input type="hidden" id="main-tab" name="main-tab" value="<?= $mainTab ?>"/>

<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li <?= $mainTab == 'tab-review' ? 'class="active"' : '' ?>><a href="#tab-review" data-toggle="tab" data-tab="tab-review" class="main-tab">Pré-cálculo</a></li>
            <li <?= $mainTab == 'tab-lancamento-hora' ? 'class="active"' : '' ?>><a href="#tab-lancamento-hora" data-toggle="tab" data-tab="tab-lancamento-hora" class="main-tab processar-horas">Lançamento de horas</a></li>
            <li <?= $mainTab == 'tab-apuracao' ? 'class="active"' : '' ?> ><a href="#tab-apuracao" data-toggle="tab" data-tab="tab-apuracao" class="main-tab processar-horas">Apuração</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade <?= $mainTab == 'tab-review' ? 'in active' : '' ?>" id="tab-review">
                <?= $this->render('pre-calculo-review/_pre_calculo_review', [
                    'model' => $preCalculo,
                    'makeHidden' => true,
                    'form' => $form
                ]) ?>
            </div>
            <div class="tab-pane fade <?= $mainTab == 'tab-lancamento-hora' ? 'in active' : '' ?>" id="tab-lancamento-hora">
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
            <div class="tab-pane fade <?= $mainTab == 'tab-apuracao' ? 'in active' : '' ?>" id="tab-apuracao">
                <?= $this->render('apuracao/_apuracao', [
                    'apuracao' => $apuracao,
                    'anosTrabalhados' => $anosTrabalhados
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>