<?php

use app\util\DateUtil;

?>

<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <?php
                foreach ($mesesTrabalhadosNoAno as $value){
            ?>       

            <li id="tab_<?= $anoPaginado ?>_<?= $value ?>" <?= $value == $mesPaginado ? 'class="active"' : '' ?>><a href="#tab_<?= $anoPaginado ?>_<?= $value ?>" data-toggle="tab"><?= DateUtil::mes_ptBR[$value] ?></a></li>

            <?php };?>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            
        <?= $this->render('_table', [
            'horasParaLancamento' => $horasParaLancamento
        ]) ?>

        </div>
    </div>
</div>