
<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <?php
                $first = true;
                foreach ($anosTrabalhados as $value){
            ?>       

            <li id="tab_apuracao_<?= $value ?>" <?= $first ? 'class="active"' : '' ?> data-ano=<?= $value ?> ><a href="#tab_ano_apuracao_<?= $value ?>" data-toggle="tab"><?= $value ?></a></li>

            <?php $first = false; };?>
            
        </ul>
    </div>

    <div class="panel-body">
        <div class="tab-content">
            <?php
                $first = true;
                foreach ($apuracao as $key => $anoApuracao){
            ?>    
                <div class="tab-pane fade <?= $first ? 'in active' : '' ?>" id="tab_ano_apuracao_<?= $key ?>"> 
                   
                    <?= $this->render('_table', [
                        'anoApuracao' => $anoApuracao
                    ]) ?>
     
                </div>

            <?php $first = false; };?>
        </div>
    </div>
</div>