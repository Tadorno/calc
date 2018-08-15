
<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <?php
                foreach ($anosTrabalhados as $value){
            ?>       

            <li id="tab_<?= $value ?>" data-ano=<?= $value ?> class="<?= $value == $anoPaginado ? 'active mudar-ano' : 'mudar-ano' ?>"><a href="#tab_<?= $value ?>" data-toggle="tab"><?= $value ?></a></li>

            <?php };?>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            
        <?= $this->render('_partial_mes', [
            'horasParaLancamento' => $horasParaLancamento,
            'mesesTrabalhadosNoAno' => $mesesTrabalhadosNoAno,
            'mesPaginado' => $mesPaginado,
            'anoPaginado' => $anoPaginado
        ]) ?>
            
        </div>
    </div>
</div>