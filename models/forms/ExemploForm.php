<?php

namespace app\models\forms;

use yii\base\Model;

class ExemploForm extends Model
{
    public $descricao;

    public function rules()
    {
        return [
            [['descricao'], 'required'],
            [['descricao'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'descricao' => 'Descrição:'
        ];
    }
}