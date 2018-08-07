<?php

namespace app\models;

use Yii;
use app\util\DateUtil;

/**
 * This is the model class for table "lancamento_hora".
 *
 * @property int $id
 * @property string $data
 * @property string $entrada_1
 * @property string $saida_1
 * @property string $entrada_2
 * @property string $saida_2
 * @property string $entrada_3
 * @property string $saida_3
 * @property string $entrada_4
 * @property string $saida_4
 * @property int $tempo_adicionado
 * @property string $horas_trabalhadas
 * @property int $id_pre_calculo
 *
 * @property PreCalculo $preCalculo
 */
class LancamentoHoraRecord extends \yii\db\ActiveRecord
{

    function iniciarData(\DateTime $date) {
        $this->dia_da_demana = DateUtil::getDiaDaSemana($date);
        $this->data = $date->format('d/m/Y');
        
        $this->dia = $date->format('d');
        $this->mes = $date->format('M');
        $this->ano = $date->format('Y');
    }

    public $dia_da_demana;

    public $dia;

    public $mes;

    public $ano;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lancamento_hora';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'horas_trabalhadas', 'horas_norturnas',  'id_pre_calculo'], 'required'],
            [['data', 'entrada_1', 'saida_1', 'entrada_2', 'saida_2', 'entrada_3', 'saida_3', 'entrada_4', 'saida_4'], 'safe'],
            [['id_pre_calculo'], 'integer'],
            [['horas_trabalhadas', 'horas_norturnas'], 'number'],
            [['id_pre_calculo'], 'exist', 'skipOnError' => true, 'targetClass' => PreCalculo::className(), 'targetAttribute' => ['id_pre_calculo' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'entrada_1' => 'Entrada 1',
            'saida_1' => 'Saida 1',
            'entrada_2' => 'Entrada 2',
            'saida_2' => 'Saida 2',
            'entrada_3' => 'Entrada 3',
            'saida_3' => 'Saida 3',
            'entrada_4' => 'Entrada 4',
            'saida_4' => 'Saida 4',
            'tempo_adicionado' => 'Tempo Adicionado',
            'horas_trabalhadas' => 'Horas Trabalhadas',
            'id_pre_calculo' => 'Id Pre Calculo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreCalculo()
    {
        return $this->hasOne(PreCalculo::className(), ['id' => 'id_pre_calculo']);
    }
}
