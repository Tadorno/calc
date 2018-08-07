<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use app\models\PreCalculoRecord;
use app\models\LancamentoHoraRecord;
use \yii\web\NotFoundHttpException;
use app\util\MessageUtil;
use app\util\DateUtil;
use app\exceptions\PreCalculoNaoIniciadoException;
use Yii;
/**
 * Description of CalculoService
 *
 * @author tulio
 */
class CalculoService extends ServiceTrait{
    
    protected function getModel(){
        return $model = new PreCalculoRecord();
    }
    
    protected function findModel($id)
    {
        if (($model = PreCalculoRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(MessageUtil::getMessage("MSGE6"));
        }
    }

    public function preCalculo(){
        $model = new PreCalculoRecord();

        $this->getRetorno()->setData($model);
        
        return $this->getRetorno();
    }

    public function calculo(){
        $preCalculo = new PreCalculoRecord();

        if($preCalculo->load(Yii::$app->request->post()) && $preCalculo->validate()){

            $dadosDeLancamento = $this->montarCamposParaLancamentoDeHoras($preCalculo);

            $this->getRetorno()->setData([
                'preCalculo' => $preCalculo,
                'horasLancadas' => $dadosDeLancamento['horasLancadas'],
                'anosTrabalhados' => $dadosDeLancamento['anosTrabalhados'],
            ]);
        } else {
            throw new PreCalculoNaoIniciadoException("Pré calculo é obrigatório");
        }
        return $this->getRetorno();
    }

    public function processarHoras(){
        
    }

    private function montarCamposParaLancamentoDeHoras(PreCalculoRecord $preCalculo){
        $dataAdmissao = DateUtil::strToDate($preCalculo->dt_admissao);
        $dataAfastamento = DateUtil::strToDate($preCalculo->dt_afastamento);
        $dataPrescricao = DateUtil::strToDate($preCalculo->dt_prescricao);

        $dataInicioContagem = $dataAdmissao < $dataPrescricao ? $dataPrescricao : $dataAdmissao;

        $horasLancadas = array();

        $anosTrabalhados = array();

        if($dataAfastamento > $dataInicioContagem){
            $intervalo = $dataInicioContagem->diff($dataAfastamento);

            
            for($i = 0; $i<$intervalo->days; $i++){

                if($i != 0){
                    $dataInicioContagem->add(new \DateInterval('P1D'));
                }

                $ano = $dataInicioContagem->format('Y');

                if(!in_array($ano, $anosTrabalhados)){
                    array_push($anosTrabalhados, $ano);
                }

                $lancamento = new LancamentoHoraRecord();
                $lancamento->iniciarData($dataInicioContagem);

                array_push($horasLancadas, $lancamento);
            }
        }

        return [ 'horasLancadas' => $horasLancadas, 'anosTrabalhados' => $anosTrabalhados];
    }
}
