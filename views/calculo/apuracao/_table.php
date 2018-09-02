<?php
    use app\util\DateUtil;
?>

<table class="table table-striped" id="tabela-apuracao">
    <thead>
        <tr>
            <th>Mês</th>
            <th>Domingo</th>
            <th>Seg. a Sex.</th>
            <th>Sábado</th>
            <th>Feriado</th>
            <th>Dias Úteis</th>
        </tr>
    </thead>
    <tbody id="tbody-tabela-apuracao">
        <?php 
            foreach ($anoApuracao as $key => $model){        
            ?>

            <tr>
                <td><?= DateUtil::mes_ptBR[$key] ?></td>
                <td><?= number_format($model['domingo'], 2); ?></td>
                <td><?= number_format($model['seg_sexta'], 2); ?></td>
                <td><?= number_format($model['sabado'], 2); ?></td>
                <td><?= number_format($model['feriado'], 2); ?></td>
                <td><?= $model['dias_uteis']; ?></td>
            </tr>

        <?php };?>
    </tbody>
  </table>