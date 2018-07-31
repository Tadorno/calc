<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Exemplo */

$model = $return->getData();
$this->title = 'Update Exemplo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Exemplos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="exemplo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>