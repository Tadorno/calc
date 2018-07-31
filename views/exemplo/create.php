<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Exemplo */

$this->title = 'Create Exemplo';
$this->params['breadcrumbs'][] = ['label' => 'Exemplos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model = $return->getData();
?>
<div class="exemplo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>