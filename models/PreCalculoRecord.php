<?php

namespace app\models;

use Yii;
use \app\util\MessageUtil;

/**
 * This is the model class for table "pre_calculo".
 *
 * @property int $id
 * @property string $processo
 * @property string $reclamada
 * @property string $reclamante
 * @property string $dt_admissao
 * @property string $dt_afastamento
 * @property string $dt_prescrissao
 * @property string $dt_atualizacao
 * @property string $dt_inicial
 * @property string $dtc_cadastro
 */
class PreCalculoRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_calculo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['processo', 'reclamada', 'reclamante', 'dt_admissao', 'dt_afastamento', 'dt_prescricao', 'dt_atualizacao', 'dt_inicial'], 'required', 'message' => MessageUtil::getMessage("MSGE3")],
            [['dt_admissao', 'dt_afastamento', 'dt_prescricao', 'dt_atualizacao', 'dtc_cadastro', 'dt_inicial'], 'safe'],
            [['processo'], 'string', 'max' => 100],
            [['reclamada', 'reclamante'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'processo' => 'Processo *',
            'reclamada' => 'Reclamada *',
            'reclamante' => 'Reclamante *',
            'dt_admissao' => 'Data de Admissão *',
            'dt_afastamento' => 'Data de Afastamento *',
            'dt_prescricao' => 'Data de Prescrição *',
            'dt_atualizacao' => 'Data de Atualização *',
            'dt_inicial' => 'Data Inicial *',
            'dtc_cadastro' => 'Data de Cadastro',
        ];
    }
}
