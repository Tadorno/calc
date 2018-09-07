<input type="hidden" id="anoPaginado" name="anoPaginado" value = "<?= $anoPaginado; ?>"/>
<input type="hidden" id="mesPaginado" name="mesPaginado" value = "<?= $mesPaginado; ?>"/>
<input type="hidden" id="tabLancamento" name="tabLancamento" value = "<?= $tabLancamento; ?>"/>

<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <?php
                foreach ($anosTrabalhados as $value){
            ?>       

            <li id="tab_<?= $value ?>" data-ano=<?= $value ?> data-tab=<?= $value ?> class="<?= $value == $tabLancamento ? 'active mudar-ano' : 'mudar-ano' ?>"><a href="#tab_ano" data-toggle="tab"><?= $value ?></a></li>

            <?php };?>
            <li data-tab-lancamento="tab-resumo-hora" class="processar-horas <?= $tabLancamento == 'tab-resumo-hora' ? 'active' : ''?>"><a href="#tab-resumo-hora" data-toggle="tab">Resumo de horas</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">

            <div class="tab-pane fade <?= $tabLancamento != 'tab-resumo-hora' ? 'in active' : ''?>" id="tab_ano"> 
                <?= $this->render('_partial_mes', [
                    'horasParaLancamento' => $horasParaLancamento,
                    'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
                    'mesPaginado' => $mesPaginado,
                    'anoPaginado' => $anoPaginado
                ]) ?>
            </div>

            <div class="tab-pane fade <?= $tabLancamento == 'tab-resumo-hora' ? 'in active' : ''?>" id="tab-resumo-hora">
                <?= $this->render('_resumo_horas',[
                    'resumoHoras' => $resumoHoras
                ] ) ?>
            </div>
        </div>
    </div>
</div>