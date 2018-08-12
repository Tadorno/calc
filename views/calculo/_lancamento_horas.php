
<?php

use app\util\DateUtil;
use yii\helpers\Html;

$script = <<< JS
    
    $(document).ready(function(){
        let lancamento_horas = $('#tbody-lancamento-horas tr');

        $("#filtrarMes").on("change", function() {
            filtrarTabela();
        });

        $("#filtrarAno").on("change", function() {
            filtrarTabela();
        });
        
        function filtrarTabela(){
            let mesSelecionado = $("#filtrarMes").val();
            let anoSelecionado = $("#filtrarAno").val();

            
            lancamento_horas.removeClass("hide");
            lancamento_horas.addClass("hide-mes hide-ano");

            if(mesSelecionado == ''){
                lancamento_horas.removeClass("hide-mes");    
            } else {
                $('.mes_' + mesSelecionado).removeClass("hide-mes");  
            }

            if(anoSelecionado == ''){
                lancamento_horas.removeClass("hide-ano"); 
            } else {
                $('.ano_' + anoSelecionado).removeClass("hide-ano");    
            }

            $('.hide-ano').addClass("hide");
            $('.hide-mes').addClass("hide");
        }
    }); 
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>

<div class="row float-right">
    <div class="col-md-2 col-md-offset-8">
        <select class="form-control" id="filtrarMes">
            <option value="">Todos os Mêses</option>
            <?php
                foreach (DateUtil::mes_extenso as $key => $value){
            ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php };?>
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-control" id="filtrarAno">
            <option value="">Todos os Anos</option>
            <?php
                foreach ($anosTrabalhados as $value){
            ?>
                <option value="<?= $value ?>"><?= $value ?></option>
            <?php };?>
            
        </select>
    </div>
</div>

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
            <div class="tab-pane fade" id="tab4">Default 4</div>
        </div>
    </div>
</div>

