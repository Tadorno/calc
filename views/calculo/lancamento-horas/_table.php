<?php
    use yii\helpers\Html;

$script = <<< JS
    $(document).ready(function(){
        $("#tab-lancamento-hora .hora").inputmask("hh:mm");
    });
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>

<table class="table table-striped" id="tabela-lancamento-horas">
    <thead>
        <tr>
            <th>Data</th>
            <th>Dia</th>
            <th>Entrada</th>
            <th>Saída</th>
            <th>Entrada</th>
            <th>Saída</th>
            <th>Entrada</th>
            <th>Saída</th>
            <th>Entrada</th>
            <th>Saída</th>
        </tr>
    </thead>
    <tbody id="tbody-lancamento-horas">
        <?php 
            foreach ($horasParaLancamento as $key => $lancamento){

                $tipoDia = ($lancamento['dia_da_semana'] == 'Sábado') ? ' sabado': (($lancamento['dia_da_semana'] == 'Domingo') ? ' domingo' : '');
            ?>

            <tr class="<?= 'ano_'  .$lancamento['ano'] . ' mes_' . $lancamento['mes'] . $tipoDia; ?>" >
                <td><?= $lancamento['data']; ?></td>
                <td><?= $lancamento['dia_da_semana']; ?></td>
                <td>
                    <input type="input" placeholder="hh:mm" class="hora altera-calculo" id="id_e1_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][entrada_1]" value="<?= $lancamento['entrada_1']?>"/>
                </td>
                <td>
                    <input type="input" placeholder="hh:mm" class="hora altera-calculo" id="id_s1_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][saida_1]" value="<?= $lancamento['saida_1']?>"/>
                </td>
                <td>
                    <input type="input" placeholder="hh:mm" class="hora altera-calculo" id="id_e2_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][entrada_2]" value="<?= $lancamento['entrada_2']?>"/>
                </td>
                <td>
                    <input type="input" placeholder="hh:mm" class="hora altera-calculo" id="id_s2_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][saida_2]" value="<?= $lancamento['saida_2']?>"/>
                </td>
                <td>
                    <input type="input" placeholder="hh:mm" class="hora altera-calculo" id="id_e3_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][entrada_3]" value="<?= $lancamento['entrada_3']?>"/>
                </td>
                <td>
                    <input type="input" placeholder="hh:mm" class="hora altera-calculo" id="id_s3_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][saida_3]" value="<?= $lancamento['saida_3']?>"/>
                </td>
                <td>
                    <input type="input" placeholder="hh:mm" class="hora altera-calculo" id="id_e4_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][entrada_4]" value="<?= $lancamento['entrada_4']?>"/>
                </td>
                <td>
                    <input type="input" placeholder="hh:mm" class="hora altera-calculo" id="id_s4_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][saida_4]" value="<?= $lancamento['saida_4']?>"/>
                </td>
            </tr>

        <?php };?>
    </tbody>
  </table>