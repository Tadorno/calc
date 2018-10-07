<input type="hidden" id="remuneracaoAnoPaginado" name="remuneracaoAnoPaginado" value = "<?= $anoPaginado; ?>"/>

<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <?php
                foreach ($anosTrabalhados as $value){
            ?>       

            <li id="tab_remuneracao_<?= $value ?>" <?= $anoPaginado == $value ? 'class="active"' : '' ?> data-ano=<?= $value ?> ><a href="#tab_ano_remuneracao_<?= $value ?>" data-toggle="tab"><?= $value ?></a></li>

            <?php }?>
            
        </ul>
    </div>

    <div class="panel-body">
        <div class="tab-content">   
            <div class="tab-pane fade in active"> 
                
                <?= $this->render('_table', [
                    'remuneracaoPage' => $remuneracaoPage
                ]) ?>
    
            </div>
        </div>
    </div>
</div>