<?php
    use yii\helpers\Html;
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

                $tipoDia = ($lancamento['dia_da_demana'] == 'Sábado') ? ' sabado': (($lancamento['dia_da_demana'] == 'Domingo') ? ' domingo' : '');
            ?>

            <tr class="<?= 'ano_'  .$lancamento['ano'] . ' mes_' . $lancamento['mes'] . $tipoDia; ?>" >
                <td><?= $lancamento['data']; ?></td>
                <td><?= $lancamento['dia_da_demana']; ?></td>
                <td>
                    <input type="time" id="id_e1_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][entrada_1]"/>
                </td>
                <td>
                    <input type="time" id="id_s1_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][saida_1]"/>
                </td>
                <td>
                    <input type="time" id="id_e2_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][entrada_2]"/>
                </td>
                <td>
                    <input type="time" id="id_s2_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][saida_2]"/>
                </td>
                <td>
                    <input type="time" id="id_e3_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][entrada_3]"/>
                </td>
                <td>
                    <input type="time" id="id_s3_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][saida_3]"/>
                </td>
                <td>
                    <input type="time" id="id_e4_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][entrada_4]"/>
                </td>
                <td>
                    <input type="time" id="id_s4_<?= $key ?>" name="LancamentoHoraRecord[<?= $key ?>][saida_4]"/>
                </td>
            </tr>

        <?php };?>
    </tbody>
  </table>