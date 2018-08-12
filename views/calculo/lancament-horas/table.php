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
            foreach ($horasLancadas as $key => $lancamento){

                $tipoDia = ($lancamento->dia_da_demana == 'Sábado') ? ' sabado': (($lancamento->dia_da_demana == 'Domingo') ? ' domingo' : '');
            ?>

            <tr class="<?= 'ano_'  .$lancamento->ano . ' mes_' . $lancamento->mes . $tipoDia; ?>" >
                <td><?= $lancamento->data; ?></td>
                <td><?= $lancamento->dia_da_demana; ?></td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'entrada_1', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[' . $key . '][entrada_1]',
                        'id' => 'id_e1_'.$key
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'saida_1', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[' . $key . '][saida_1]',
                        'id' => 'id_s1_'.$key
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'entrada_2', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[' . $key . '][entrada_2]',
                        'id' => 'id_e2_'.$key
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'saida_2', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[' . $key . '][saida_2]',
                        'id' => 'id_s2_'.$key
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'entrada_3', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[' . $key . '][entrada_3]',
                        'id' => 'id_e3_'.$key
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'saida_3', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[' . $key . '][saida_3]',
                        'id' => 'id_s3_'.$key
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'entrada_4', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[' . $key . '][entrada_4]',
                        'id' => 'id_e4_'.$key
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'saida_4', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[' . $key . '][saida_4]',
                        'id' => 'id_s4_'.$key
                    ] ); ?>
                </td>
            </tr>

        <?php };?>
    </tbody>
  </table>