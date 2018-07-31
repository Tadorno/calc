<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FeriadoRecord */

$this->title = 'Novo Feriado';
$this->params['breadcrumbs'][] = ['label' => 'Feriado', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feriado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'mesList' => $mesList
    ]) ?>

</div>
