

<?= $this->render('lancamento-horas/_partial_ano', [
    'horasParaLancamento' => $horasParaLancamento,
    'anosTrabalhados' => $anosTrabalhados,
    'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
    'anoPaginado' => $anoPaginado,
    'mesPaginado' => $mesPaginado,
    'resumoHoras' => $resumoHoras
]) ?>

