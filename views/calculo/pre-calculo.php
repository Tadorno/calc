<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;

$this->title = 'Pré-Cálculo';

$script = <<< JS
    $(document).ready(function(){
        $("#confirmButton").on("click", function(event) {
            $("#confirm-form").val("false");
            $('#id-pre-calculo-form').yiiActiveForm('validate', true);
        });

        $("#confirm-pre-calc").on("click", function(event) {
            $("#confirm-form").val("true");
            $('#id-pre-calculo-form').submit();
        });

        $('#id-pre-calculo-form').on('afterValidate', function (event, messages, errorAttributes) {
            if(errorAttributes.length === 0){
                $("#modal-confirm").modal('show');
            }
        });

        $('#id-pre-calculo-form').on('beforeSubmit', function (event) {
            return $("#confirm-form").val() == "true";
        });
    }); 
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>

<div class="pre-calculo-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
            'id' => 'id-pre-calculo-form',
            'layout' => 'horizontal'
        ]); ?>

    <input type="hidden" id="confirm-form" value="false"/>

    <div class="col-md-12">
        <?= $form->field($model, 'processo', [
                'template' => '{label}<div class="col-sm-4">{input}{error}</div>'
            ])->textInput([
                'maxlength' => true,
                'onchange'=> '$("#span_processo").text($(this).val());'
            ]) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'reclamada', [
                'template' => '{label}<div class="col-sm-4">{input}{error}</div>'
            ])->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'reclamante', [
                'template' => '{label}<div class="col-sm-4">{input}{error}</div>'
            ])->textInput(['maxlength' => true]) ?>
    </div>

    <div class="row" >
        <div class="col-md-6">
            <?= $form->field($model,'dt_admissao', [
                    'template' => Html::activeLabel($model, 'dt_admissao', ['class' => 'control-label col-sm-6']) .'<div class="col-sm-6">{input}{error}</div>'
                ])->widget(DatePicker::className(),[
                    'options' => ['class' => 'form-control', 'readonly' => 'readonly', 'style' => 'background:white;'],
                    'dateFormat' => 'dd/MM/yyyy',
                    'clientOptions' => [
                        'onClose' => new \yii\web\JsExpression('function( selectedDate ) {
                            $( "#'.Html::getInputId($model, 'dt_afastamento').'" ).datepicker( "option", "minDate", selectedDate ); 
                        }'),]
                    ]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model,'dt_afastamento', [
                    'template' => Html::activeLabel($model, 'dt_afastamento', ['class' => 'control-label col-sm-6']) .'<div class="col-sm-6">{input}{error}</div>'
                ])->widget(DatePicker::className(),[
                    'options' => ['class' => 'form-control', 'readonly' => 'readonly', 'style' => 'background:white;'],
                    'dateFormat' => 'dd/MM/yyyy',
                    'clientOptions' => [
                        'onClose' => new \yii\web\JsExpression('function( selectedDate ) {
                            $( "#'.Html::getInputId($model, 'dt_admissao').'" ).datepicker( "option", "maxDate", selectedDate ); 
                        }'),]
                    ]) ?>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-6">
            <?= $form->field($model,'dt_inicial', [
                    'template' => Html::activeLabel($model, 'dt_inicial', ['class' => 'control-label col-sm-6']) .'<div class="col-sm-6">{input}{error}</div>'
                ])->widget(DatePicker::className(),[
                    'options' => ['class' => 'form-control', 'readonly' => 'readonly', 'style' => 'background:white;'],
                    'dateFormat' => 'dd/MM/yyyy',
                    'clientOptions' => [
                        'onClose' => new \yii\web\JsExpression('function( selectedDate ) {
                            var d = new Date($.datepicker.formatDate("yy-mm-dd", $(this).datepicker("getDate")) + "T00:00:00-03:00");
                            d.setFullYear(d.getFullYear()-5);
                            $( "#'.Html::getInputId($model, 'dt_prescricao').'" ).datepicker( "setDate", d ); 
                            $( "#'.Html::getInputId($model, 'dt_prescricao').'" ).blur();
                        }'),]
                ]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model,'dt_prescricao', [
                    'template' => Html::activeLabel($model, 'dt_prescricao', ['class' => 'control-label col-sm-6']) .'<div class="col-sm-6">{input}{error}</div>'
                ])->widget(DatePicker::className(),[
                    'options' => ['class' => 'form-control', 'readonly' => 'readonly', 'style' => 'background:white;'],
                    'dateFormat' => 'dd/MM/yyyy'
                ]) ?>
        </div>
    </div>

    <div class="col-md-6">
        <?= $form->field($model,'dt_atualizacao', [
                'template' => Html::activeLabel($model, 'dt_atualizacao', ['class' => 'control-label col-sm-6']) .'<div class="col-sm-6">{input}{error}</div>'
            ])->widget(DatePicker::className(),[
                'options' => ['class' => 'form-control', 'readonly' => 'readonly', 'style' => 'background:white;'],
                'dateFormat' => 'dd/MM/yyyy']) ?>
    </div>

    <div class="col-md-12" style="text-align:center">
        <div class="form-group">
            <?= Html::a('Iniciar Cálculo', '#', ['class' => 'btn-lg btn-success', 'id' => 'confirmButton']) ?>
        </div> 
    </div> 

    <?php

        $footer = '<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>';
        $footer .= '<button type="button" class="btn btn-success" id="confirm-pre-calc">Iniciar</button>';

        Modal::begin([
                'header' => '<h4>Pré-Cálculo</h4>',
                'id'     => 'modal-confirm',
                'size'   => 'model-lg',
                'footer' => $footer
        ]);
        
            echo "<div id='modelContent'>";
                echo "<h4>Atenção, favor confirmar os dados de entrada para iniciar o cálculo!<h4>";
                echo "<ht/>";
                echo "<span id='span_processo'></span>";
            echo "</div>";
        Modal::end();
    ?>

    <?php ActiveForm::end(); ?>

</div>