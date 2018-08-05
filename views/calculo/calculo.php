<?php

use yii\helpers\Html;

$this->title = 'Cálculo';

?>
<div class="calculo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li><a href="#tab1" data-toggle="tab">Pré-cálculo</a></li>
                    <li class="active"><a href="#tab2" data-toggle="tab">Lançamento de horas</a></li>
                    <li><a href="#tab3" data-toggle="tab">Default 3</a></li>
                    <li><a href="#tab4" data-toggle="tab">Default 4</a></li>
                </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade" id="tab1">Default 1</div>
                <div class="tab-pane fade in active" id="tab2">Default 2</div>
                <div class="tab-pane fade" id="tab3">Default 3</div>
                <div class="tab-pane fade" id="tab4">Default 4</div>
            </div>
        </div>
    </div>
</div>