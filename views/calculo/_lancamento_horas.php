
<?php

use app\util\DateUtil;
use yii\helpers\Html;

$script = <<< JS
    
    $(document).ready(function(){

    }); 
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>
<input type="hidden" id="anoPaginado" value = "<?= $anoPaginado; ?>"/>
<input type="hidden" id="mesPaginado" value = "<?= $mesPaginado; ?>"/>
<div class="panel with-nav-tabs panel-default" style="margin-top:15px;">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <?php
                $first = "class = 'active'";
                foreach ($anosTrabalhados as $value){
            ?>       

            <li <?= $first ?>><a href="#tab<?= $value ?>" data-toggle="tab"><?= $value ?></a></li>

            <?php  $first = ""; };?>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            asd
            
        </div>
    </div>
</div>

