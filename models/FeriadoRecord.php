<?php

namespace app\models;

use \app\util\MessageUtil;
use app\enums\MesEnum;
use Yii;

/**
 * This is the model class for table "feriado".
 *
 * @property int $id
 * @property string $descricao
 * @property int $dia
 * @property int $mes
 */
class FeriadoRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feriado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'dia', 'mes'], 'required', 'message' => MessageUtil::getMessage("MSGE3")],
            ['descricao', 'trim'],
            [['dia', 'mes'], 'integer', 'message' => MessageUtil::getMessage("MSGE5")],
            [['descricao'], 'string', 'max' => 100],
            [['descricao'], 'unique' , 'message' => MessageUtil::getMessage("MSGE4")]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descrição *',
            'dia' => 'Dia *',
            'mes' => 'Mês *',
        ];
    }

    public function getData(){
        return str_pad($this->dia, 2, '0', STR_PAD_LEFT) . '/' . MesEnum::toString($this->mes);
    }
}
