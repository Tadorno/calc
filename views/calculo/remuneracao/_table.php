<?php
    use app\util\DateUtil;

$script = <<< JS
    $(document).ready(function(){
        $("#tab-remuneracao .decimal-2").inputmask({alias: 'numeric', 
                       allowMinus: false,  
                       digits: 2});
    });
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>

<table class="table table-striped" id="tabela-remuneracao">
    <thead>
        <tr>
            <th>Mês</th>
            <th>R 1</th>
            <th>R 2</th>
            <th>R 3</th>
            <th>R 4</th>
            <th>R 5</th>
        </tr>
    </thead>
    <tbody id="tbody-remuneracao">
        <?php 
            foreach ($remuneracaoPage as $key => $remuneracao){
        ?>
            <tr>
                <td><?= DateUtil::mes_ptBR[$key] ?></td>
                <td>
                    <input type="input" class="decimal-2 altera-remuneracao" id="id_r1_<?= $key ?>" name="RemuneracaoRecord[<?= $key ?>][r_1]" value="<?= $remuneracao['r_1']?>"/>
                </td>
                <td>
                    <input type="input" class="decimal-2 altera-remuneracao" id="id_r2_<?= $key ?>" name="RemuneracaoRecord[<?= $key ?>][r_2]" value="<?= $remuneracao['r_2']?>"/>
                </td>
                <td>
                    <input type="input" class="decimal-2 altera-remuneracao" id="id_r3_<?= $key ?>" name="RemuneracaoRecord[<?= $key ?>][r_3]" value="<?= $remuneracao['r_3']?>"/>
                </td>
                <td>
                    <input type="input" class="decimal-2 altera-remuneracao" id="id_r4_<?= $key ?>" name="RemuneracaoRecord[<?= $key ?>][r_4]" value="<?= $remuneracao['r_4']?>"/>
                </td>
                <td>
                    <input type="input" class="decimal-2 altera-remuneracao" id="id_r5_<?= $key ?>" name="RemuneracaoRecord[<?= $key ?>][r_5]" value="<?= $remuneracao['r_5']?>"/>
                </td>
            </tr>
        <?php }?>
    </tbody>
  </table>