<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\enums\MesEnum;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FeriadoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feriado';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feriado-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descricao',
            'data',

            ['class' => 'app\components\CustomActionColumn'],
        ],
    ]); ?>
</div>
