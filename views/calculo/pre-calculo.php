<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Pré-Calculo';
?>

<div class="pre-calculo-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
            'id' => 'id-pre-cadastrado',
            'layout' => 'horizontal'
        ]); ?>

    <div class="col-md-12">
        <?= $form->field($model, 'processo', [
                'template' => '{label}<div class="col-sm-4">{input}{error}</div>'
            ])->textInput(['maxlength' => true]) ?>
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
                            $( "#'.Html::getInputId($model, 'dt_prescricao').'" ).datepicker( "option", "defaultDate", selectedDate ); 
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

    <?php ActiveForm::end(); ?>

</div>