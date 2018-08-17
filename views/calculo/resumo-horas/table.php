<table class="table table-striped" id="tabela-resumo-horas">
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
        <?php 
            foreach ($horasParaLancamento as $key => $lancamento){
                $tipoDia = ($lancamento['dia_da_demana'] == 'Sábado') ? ' sabado': (($lancamento['dia_da_demana'] == 'Domingo') ? ' domingo' : '');
        ?>

        <tr class="<?= 'ano_'  .$lancamento['ano'] . ' mes_' . $lancamento['mes'] . $tipoDia; ?>" >
            <td><?= $lancamento['data']; ?></td>

            <td><?= $lancamento['dia_da_demana']; ?></td>

            <td><span id="id_horas_trabalhadas_<?= $key ?>">0.00</span></td>

            <td><span id="id_horas_diurnas_<?= $key ?>">0.00</span></td>

            <td><span id="id_horas_noturnas_<?= $key ?>">0.00</span></td>
        </tr>

        <?php };?>
    </tbody>
</table>