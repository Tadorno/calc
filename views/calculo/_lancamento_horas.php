
<?php

use app\util\DateUtil;

$script = <<< JS
    $(document).ready(function(){
        $("#filtrarMes").on("change", function() {
            Loading.show();
            filtrarTabela();
        });

        $("#filtrarAno").on("change", function() {
            filtrarTabela();
        });
        
        function filtrarTabela(){
            let mesSelecionado = $("#filtrarMes").val();
            let anoSelecionado = $("#filtrarAno").val();

            $('#tbody-lancamento-horas tr').removeClass("hide");
            $('#tbody-lancamento-horas tr').addClass("hide-mes");
            $('#tbody-lancamento-horas tr').addClass("hide-ano");

            if(mesSelecionado == ''){
                $('#tbody-lancamento-horas tr').removeClass("hide-mes");    
            } else {
                $('.mes_' + mesSelecionado).removeClass("hide-mes");  
            }

            if(anoSelecionado == ''){
                $('#tbody-lancamento-horas tr').removeClass("hide-ano"); 
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
            <th>Tempo Adicionado</th>
            <th>Horas Trabalhadas</th>
        </tr>
    </thead>
    <tbody id="tbody-lancamento-horas">
        <?php 
            foreach ($horasLancadas as $lancamento){

                $tipoDia = ($lancamento->dia_da_demana == 'Sábado') ? ' sabado': (($lancamento->dia_da_demana == 'Domingo') ? ' domingo' : '');
            ?>

            <tr class="<?= 'ano_'  .$lancamento->ano . ' mes_' . $lancamento->mes . $tipoDia; ?>" >
                <td><?= $lancamento->data; ?></td>
                <td><?= $lancamento->dia_da_demana; ?></td>
                <td><input type="time" /></td>
                <td><input type="time" /></td>
                <td><input type="time" /></td>
                <td><input type="time" /></td>
                <td><input type="time" /></td>
                <td><input type="time" /></td>
                <td><input type="time" /></td>
                <td><input type="time" /></td>
                <td>0</td>
                <td>00:00</td>
            </tr>

        <?php };?>
    </tbody>
  </table>