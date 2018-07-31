<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FeriadoRecord */

$this->title = 'Atualizar Feriado';
$this->params['breadcrumbs'][] = ['label' => 'Feriados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="feriado-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'mesList' => $mesList
    ]) ?>

</div>
