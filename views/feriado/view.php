<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \app\util\MessageUtil;

/* @var $this yii\web\View */
/* @var $model app\models\FeriadoRecord */

$this->title = $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Feriados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feriado-record-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => MessageUtil::getMessage("MSGA1"),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descricao',
            'data'
        ],
    ]) ?>

</div>
