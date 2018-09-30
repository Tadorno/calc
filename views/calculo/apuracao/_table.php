<?php
    use app\util\DateUtil;
?>

<table class="table table-striped" id="tabela-apuracao">
    <thead>
        <tr>
            <th>Mês</th>
            <th>Dom</th>
            <th>Seg</th>
            <th>Ter</th>
            <th>Qua</th>
            <th>Qui</th>
            <th>Sex</th>
            <th>Sab</th>
            <th>F.</th>
            <th>D. U.</th>
            <th>H. C.</th>
        </tr>
    </thead>
    <tbody id="tbody-tabela-apuracao">
        <?php 
            foreach ($anoApuracao as $key => $model){        
            ?>

            <tr>
                <td><?= DateUtil::mes_ptBR[$key] ?></td>
                <td><?= $model['Sun']; ?></td>
                <td><?= $model['Mon']; ?></td>
                <td><?= $model['Tue']; ?></td>
                <td><?= $model['Wed']; ?></td>
                <td><?= $model['Thu']; ?></td>
                <td><?= $model['Fri']; ?></td>
                <td><?= $model['Sat']; ?></td>
                <td><?= $model['feriado']; ?></td>
                <td><?= $model['dias_uteis']; ?></td>
                <td>0</td>
            </tr>

        <?php };?>
    </tbody>
  </table>