<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exemplo".
 *
 * @property integer $id
 * @property string $descricao
 */
class ExemploRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exemplo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descricao'], 'required'],
            [['descricao'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'descricao' => 'Descrição',
        ];
    }
}
