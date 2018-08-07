
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
<input type="button" value="Processar Horas" class="processar-horas"/>
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
            <th>Horas Trabalhadas</th>
            <th>Horas Noturnas</th>
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
                <td>
                    <?= Html::activeTextInput($lancamento, 'entrada_1', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[][entrada_1]',
                        'id' => 'id_e1_'.$lancamento->dia.'_'.$lancamento->mes.'_'.$lancamento->ano
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'saida_1', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[][saida_1]',
                        'id' => 'id_s1_'.$lancamento->dia.'_'.$lancamento->mes.'_'.$lancamento->ano
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'entrada_2', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[][entrada_2]',
                        'id' => 'id_e2_'.$lancamento->dia.'_'.$lancamento->mes.'_'.$lancamento->ano
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'saida_2', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[][saida_2]',
                        'id' => 'id_s2_'.$lancamento->dia.'_'.$lancamento->mes.'_'.$lancamento->ano
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'entrada_3', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[][entrada_3]',
                        'id' => 'id_e3_'.$lancamento->dia.'_'.$lancamento->mes.'_'.$lancamento->ano
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'saida_3', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[][saida_3]',
                        'id' => 'id_s3_'.$lancamento->dia.'_'.$lancamento->mes.'_'.$lancamento->ano
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'entrada_4', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[][entrada_4]',
                        'id' => 'id_e4_'.$lancamento->dia.'_'.$lancamento->mes.'_'.$lancamento->ano
                    ] ); ?>
                </td>
                <td>
                    <?= Html::activeTextInput($lancamento, 'saida_4', [
                        'type' => 'time',
                        'name' => 'LancamentoHoraRecord[][saida_4]',
                        'id' => 'id_s4_'.$lancamento->dia.'_'.$lancamento->mes.'_'.$lancamento->ano
                    ] ); ?>
                </td>
                <td>0</td>
                <td>0</td>
            </tr>

        <?php };?>
    </tbody>
  </table>