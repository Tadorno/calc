<?php

use app\util\DateUtil;
$script = <<< JS

    $(document).ready(function(){
        $("#tab-resumo-hora").on("click", function(event) {
            console.log("aaa")
        });
        $('#treeview').on('click', '.treeview-item', function(event) {
            console.log("foi")
            //nodeid = $(this).data('nodeid');
           // $("#treeview ."nodeid).removeClass("hide");
        });
    }); 
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>

<?php if(!isset($resumoHoras)){ ?>
<div class="jumbotron">
    <p class="lead">Imputação de horas não processada.</p>
</div>

<?php }else{ ?>
<div class="treeview" id="treeview">
    <ul class="list-group">
    <?php foreach ($resumoHoras as $anoKey => $anoValues){ ?>
        <li class="list-group-item node-treeview treeview-item">
            <div data-nodeid="ano_<?php $anoKey ?>" class="treeview-item">
                <span class="icon expand-icon glyphicon glyphicon-minus"></span>
                <b><?= $anoKey ?>:
                <span class="indent"></span>Horas Trabalhadas: <?= number_format($anoValues['total']['horas_trabalhadas'], 2) ?>
                <span class="indent"></span>Horas Diurnas: <?= number_format($anoValues['total']['horas_diurnas'], 2) ?>
                <span class="indent"></span>Horas Noturnas: <?= number_format($anoValues['total']['horas_noturnas'], 2) ?></b>
            </div>

            <ul class="list-group ano_<?php $anoKey ?> hide">
                <?php foreach ($anoValues as $mesKey => $mesValues){ if($mesKey != 'total'){ ?>
                    <li class="list-group-item node-treeview">
                        <div data-nodeid="mes_<?php $mesKey ?>" class="treeview-item">
                            <span class="icon expand-icon glyphicon glyphicon-minus"></span>
                            <b><?= DateUtil::mes_ptBR[$mesKey] ?>:
                            <span class="indent">Horas Trabalhadas: <?= number_format($mesValues['total']['horas_trabalhadas'], 2) ?>
                            <span class="indent">Horas Diurnas: <?= number_format($mesValues['total']['horas_diurnas'], 2) ?>
                            <span class="indent">Horas Noturnas: <?= number_format($mesValues['total']['horas_noturnas'], 2) ?></b>
                        </div>
                        <table class="table table-striped mes_<?php $mesKey ?> hide" id="tabela-resumo-horas">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Dia</th>
                                    <th>Horas Trabalhadas</th>
                                    <th>Horas Diurnas</th>
                                    <th>Horas Noturnas</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-resumo-horas">
                            <?php foreach ($mesValues as $diaKey => $diaValues){ if($diaKey != 'total'){ 
                                   
                                    $tipoDia = ($diaValues['dia_da_semana'] == 'Sábado') ? ' sabado': (($diaValues['dia_da_semana'] == 'Domingo') ? ' domingo' : '');
                                ?>
                                <tr class="<?= $tipoDia; ?>" >
                                    <td><?= $diaValues['data']; ?></td>

                                    <td><?= $diaValues['dia_da_semana']; ?></td>

                                    <td><?= number_format($diaValues['horas_trabalhadas'], 2)?></td>

                                    <td><?= number_format($diaValues['horas_diurnas'], 2)?></td>

                                    <td><?= number_format($diaValues['horas_noturnas'], 2)?></td>
                                </tr>    
                            <?php }}?>    
                            </tbod>
                        </table>
                    </li>
                <?php }}?>
            </ul> 
        
        </li>
    <?php }?>
    </ul>
</div>
<?php } ?>