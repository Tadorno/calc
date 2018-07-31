<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;;

/* @var $this yii\web\View */
/* @var $model app\models\FeriadoRecord */
/* @var $form yii\bootstrap\ActiveForm */

$script = <<< JS
    $(document).ready(function(){

        $("#feriadorecord-mes").on("change", function() {
            let mes = $("#feriadorecord-mes").val();

            $("#feriadorecord-dia").val('');
            
            if(mes >= 1){
                $("#feriadorecord-dia").removeAttr("readonly");
            }else{
                $("#feriadorecord-dia").attr("readonly", "readonly");
            }
        });

        $("#feriadorecord-dia").on("change", function() {
            let dia = $("#feriadorecord-dia").val();
            let mes = $("#feriadorecord-mes").val();

            if(mes >= 1){
                if(dia < 1 ){
                    $("#feriadorecord-dia").val(1);
                    return;
                }

                if(mes == 1 && dia > 31){
                    $("#feriadorecord-dia").val(31);
                    return;
                }
    
                if(mes == 2 && dia > 29){
                    $("#feriadorecord-dia").val(29);
                    return;
                }

                if(mes == 3 && dia > 31){
                    $("#feriadorecord-dia").val(31);
                    return;
                }

                if(mes == 4 && dia > 30){
                    $("#feriadorecord-dia").val(30);
                    return;
                }

                if(mes == 5 && dia > 31){
                    $("#feriadorecord-dia").val(31);
                    return;
                }

                if(mes == 6 && dia > 30){
                    $("#feriadorecord-dia").val(30);
                    return;
                }

                if(mes == 7 && dia > 31){
                    $("#feriadorecord-dia").val(31);
                    return;
                }

                if(mes == 8 && dia > 31){
                    $("#feriadorecord-dia").val(31);
                    return;
                }

                if(mes == 9 && dia > 30){
                    $("#feriadorecord-dia").val(30);
                    return;
                }

                if(mes == 10 && dia > 31){
                    $("#feriadorecord-dia").val(31);
                    return;
                }

                if(mes == 11 && dia > 30){
                    $("#feriadorecord-dia").val(30);
                    return;
                }

                if(mes == 12 && dia > 31){
                    $("#feriadorecord-dia").val(31);
                    return;
                }

            }
        });
    }); 
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>


<div class="feriado-form">

    <?php $form = ActiveForm::begin([
            'id' => 'id-form-feriado',
            'layout' => 'horizontal'
        ]); ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mes', [
            'template' => '{label}<div class="col-sm-2">{input}{error}</div>'
        ])->dropDownList(
            $mesList,
            [
                'prompt' => 'Selecione o mês...',
                'class' => 'form-control'
            ]
        ) ?>
    
    <?= $form->field($model, 'dia', [
            'template' => '{label}<div class="col-sm-2">{input}{error}</div>'
        ])->textInput(
            [ 
                'type' => 'number',
                'readonly' => 'readonly'
            ]
        ) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', [
                'id' => 'btn-submit',
                'class' => 'btn btn-success'
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
