<?php

use yii\helpers\Html;

?>

<?php
    if(isset($makeHidden) && $makeHidden){
        //Adiciona inputs hidden para reencaminhar para o cadastro do cálculo
        echo $form->field($model, 'processo', ['template' => '{input}','options' => [ 'class' => '']])->hiddenInput();
        echo $form->field($model, 'reclamada', ['template' => '{input}','options' => [ 'class' => '']])->hiddenInput();
        echo $form->field($model, 'reclamante', ['template' => '{input}','options' => [ 'class' => '']])->hiddenInput();
        echo $form->field($model, 'dt_admissao', ['template' => '{input}','options' => [ 'class' => '']])->hiddenInput();
        echo $form->field($model, 'dt_afastamento', ['template' => '{input}','options' => [ 'class' => '']])->hiddenInput();
        echo $form->field($model, 'dt_inicial', ['template' => '{input}','options' => [ 'class' => '']])->hiddenInput();
        echo $form->field($model, 'dt_prescricao', ['template' => '{input}','options' => [ 'class' => '']])->hiddenInput();
        echo $form->field($model, 'dt_atualizacao', ['template' => '{input}','options' => [ 'class' => '']])->hiddenInput();
    }
?>

<div id='preview-content'>
    
    <div class="row" style="margin-top:20px">
        <div class="form-group">
            <?= Html::activeLabel($model, "processo", ['class' => 'control-label col-sm-4']); ?>
            <label  id='span_processo' class='control-label col-sm-8' style="text-align: left !important;"><?= $model->processo; ?></label>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?= Html::activeLabel($model, "reclamada", ['class' => 'control-label col-sm-4']); ?>
            <label  id='span_reclamada' class='control-label col-sm-8' style="text-align: left !important;"><?= $model->reclamada; ?></label>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?= Html::activeLabel($model, "reclamante", ['class' => 'control-label col-sm-4']); ?>
            <label  id='span_reclamante' class='control-label col-sm-8' style="text-align: left !important;"><?= $model->reclamante; ?></label>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?= Html::activeLabel($model, "dt_admissao", ['class' => 'control-label col-sm-4']); ?>
            <label id='span_dt_admissao' class='control-label col-sm-2' style="text-align: left !important;"><?= $model->dt_admissao; ?></label>
                        
            <?= Html::activeLabel($model, "dt_afastamento", ['class' => 'control-label col-sm-4']); ?>
            <label id='span_dt_afastamento' class='control-label col-sm-2' style="text-align: left !important;"><?= $model->dt_afastamento; ?></label>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?= Html::activeLabel($model, "dt_inicial", ['class' => 'control-label col-sm-4']); ?>
            <label id='span_dt_inicial' class='control-label col-sm-2' style="text-align: left !important;"><?= $model->dt_inicial; ?></label>

            <?= Html::activeLabel($model, "dt_prescricao", ['class' => 'control-label col-sm-4']); ?>
            <label id='span_dt_prescricao' class='control-label col-sm-2' style="text-align: left !important;"><?= $model->dt_prescricao; ?></label>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?= Html::activeLabel($model, "dt_atualizacao", ['class' => 'control-label col-sm-4']); ?>
            <label id='span_dt_atualizacao' class='control-label col-sm-2' style="text-align: left !important;"><?= $model->dt_atualizacao; ?></label>
        </div>
    </div>
</div>