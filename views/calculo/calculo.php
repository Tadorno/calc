<?php

use yii\helpers\Html;
use edwinhaq\simpleloading\SimpleLoading;

SimpleLoading::widget();

$this->title = 'Cálculo';

$this->registerJsFile("@web/js/calculo/calculo.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("@web/js/calculo/lancamento-horas.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("@web/js/calculo/apuracao.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

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