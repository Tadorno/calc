<input type="hidden" id="anoPaginado" name="anoPaginado" value = "<?= $anoPaginado; ?>"/>
<input type="hidden" id="mesPaginado" name="mesPaginado" value = "<?= $mesPaginado; ?>"/>

<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <?php
                foreach ($anosTrabalhados as $value){
            ?>       

            <li id="tab_<?= $value ?>" data-ano=<?= $value ?> class="<?= $value == $anoPaginado ? 'active mudar-ano' : 'mudar-ano' ?>"><a href="#tab_ano" data-toggle="tab"><?= $value ?></a></li>

            <?php };?>
            <li><a href="#tab-resumo-hora" data-toggle="tab" data-tab="tab-resumo-hora" clas="processar-horas">Resumo de horas</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">

            <div class="tab-pane fade in active" id="tab_ano"> 
                <?= $this->render('_partial_mes', [
                    'horasParaLancamento' => $horasParaLancamento,
                    'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
                    'mesPaginado' => $mesPaginado,
                    'anoPaginado' => $anoPaginado
                ]) ?>
            </div>

            <div class="tab-pane fade" id="tab-resumo-hora">
                <?= $this->render('_resumo_horas',[
                    'resumoHoras' => $resumoHoras
                ] ) ?>
            </div>
        </div>
    </div>
</div>