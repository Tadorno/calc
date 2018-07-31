<?php

namespace app\models;

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
            [['descricao', 'dia', 'mes'], 'required', 'message' => 'Campo obrigatório.'],
            ['descricao', 'trim'],
            [['dia', 'mes'], 'integer'],
            [['descricao'], 'string', 'max' => 100],
            [['descricao'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descrição',
            'dia' => 'Dia',
            'mes' => 'Mês',
        ];
    }
}
