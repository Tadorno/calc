<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Exemplo';
$this->params['breadcrumbs'][] = ['label' => 'Exemplos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="exemplo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>