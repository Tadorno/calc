<input type="hidden" id="anoPaginado" value = "<?= $anoPaginado; ?>"/>
<input type="hidden" id="mesPaginado" value = "<?= $mesPaginado; ?>"/>

<?= $this->render('lancamento-horas/_partial_ano', [
    'horasParaLancamento' => $horasParaLancamento,
    'anosTrabalhados' => $anosTrabalhados,
    'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
    'anoPaginado' => $anoPaginado,
    'mesPaginado' => $mesPaginado
]) ?>

