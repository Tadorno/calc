
<?php

$script = <<< JS
    
    $(document).ready(function(){

    }); 
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>
<input type="hidden" id="anoPaginado" value = "<?= $anoPaginado; ?>"/>
<input type="hidden" id="mesPaginado" value = "<?= $mesPaginado; ?>"/>

<?= $this->render('lancamento-horas/_partial_ano', [
    'horasParaLancamento' => $horasParaLancamento,
    'anosTrabalhados' => $anosTrabalhados,
    'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
    'anoPaginado' => $anoPaginado,
    'mesPaginado' => $mesPaginado
]) ?>

