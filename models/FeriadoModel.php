<?php

namespace app\models;

use app\enums\MesEnum;


class FeriadoModel extends \yii\base\Model
{
    public $id;
    public $descricao;
    public $data;

    public function __construct(FeriadoRecord $record){
        $this->id = $record->id;
        $this->descricao = $record->descricao;
        $this->data = str_pad($record->dia, 2, '0', STR_PAD_LEFT) . '/' . MesEnum::toString($record->mes);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descrição',
            'data' => 'Data'
        ];
    }
}