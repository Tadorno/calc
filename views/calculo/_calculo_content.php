<?php
    use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin([
            'id' => 'id-calculo-form',
            'layout' => 'horizontal'
        ]); ?>

<input type="hidden" id="main-tab" name="main-tab" value="<?= $mainTab ?>"/>
<input type="hidden" id="anoPaginado" name="anoPaginado" value = "<?= $anoPaginado; ?>"/>
<input type="hidden" id="mesPaginado" name="mesPaginado" value = "<?= $mesPaginado; ?>"/>


<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li <?= $mainTab == 'tab-review' ? 'class="active"' : '' ?>><a href="#tab-review" data-toggle="tab" data-tab="tab-review" class="main-tab">Pré-cálculo</a></li>
            <li <?= $mainTab == 'tab-lancamento-hora' ? 'class="active"' : '' ?>><a href="#tab-lancamento-hora" data-toggle="tab" data-tab="tab-lancamento-hora" class="main-tab">Lançamento de horas</a></li>
            <li <?= $mainTab == 'tab-resumo-hora' ? 'class="active"' : '' ?>><a href="#tab-resumo-hora" data-toggle="tab" data-tab="tab-resumo-hora" class="main-tab">Resumo de horas</a></li>
            <li <?= $mainTab == 'tab-apuracao' ? 'class="active"' : '' ?> ><a href="#tab-apuracao" data-toggle="tab" data-tab="tab-apuracao" class="main-tab">Apuração</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade <?= $mainTab == 'tab-review' ? 'in active' : '' ?>" id="tab-review">
                <?= $this->render('_pre_calculo_review', [
                    'model' => $preCalculo,
                    'makeHidden' => true,
                    'form' => $form
                ]) ?>
            </div>
            <div class="tab-pane fade <?= $mainTab == 'tab-lancamento-hora' ? 'in active' : '' ?>" id="tab-lancamento-hora">
                <?= $this->render('_lancamento_horas', [
                    'horasParaLancamento' => $horasParaLancamento,
                    'anosTrabalhados' => $anosTrabalhados,
                    'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
                    'mesPaginado' => $mesPaginado,
                    'anoPaginado' => $anoPaginado
                ]) ?>
            </div>
            <div class="tab-pane fade <?= $mainTab == 'tab-resumo-hora' ? 'in active' : '' ?>" id="tab-resumo-hora">
                <?= $this->render('_resumo_horas',[
                    'resumoHoras' => $resumoHoras
                ] ) ?>
            </div>
            <div class="tab-pane fade <?= $mainTab == 'tab-apuracao' ? 'in active' : '' ?>" id="tab-apuracao">
                <?= $this->render('_apuracao') ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>