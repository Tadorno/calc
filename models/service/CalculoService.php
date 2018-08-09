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
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            $lancamentos = Yii::$app->request->post();

            foreach($lancamentos['LancamentoHoraRecord'] as $key => $lancamento){
                $lancamentos['LancamentoHoraRecord'][$key]['horas_trabalhadas'] = $this->calcularHorasTrabalhadas($lancamento);
                $lancamentos['LancamentoHoraRecord'][$key]['horas_noturnas'] = $this->calcularHorasNoturnas($lancamento);
                
            }
            
            return json_encode($lancamentos);
        }
    }

    private function calcularHorasTrabalhadas($lancamento){
        $intervalo_1 = $this->calcularIntervalo($lancamento['entrada_1'], $lancamento['saida_1']);
        $intervalo_2 = $this->calcularIntervalo($lancamento['entrada_2'], $lancamento['saida_2']);
        $intervalo_3 = $this->calcularIntervalo($lancamento['entrada_3'], $lancamento['saida_3']);
        $intervalo_4 = $this->calcularIntervalo($lancamento['entrada_4'], $lancamento['saida_4']);

        return $intervalo_1 + $intervalo_2 + $intervalo_3 + $intervalo_4;
    }

    private function calcularHorasNoturnas($lancamento){
        $intervalo_1 = $this->calcularIntervaloNortuno($lancamento['entrada_1'], $lancamento['saida_1']);
        $intervalo_2 = $this->calcularIntervaloNortuno($lancamento['entrada_2'], $lancamento['saida_2']);
        $intervalo_3 = $this->calcularIntervaloNortuno($lancamento['entrada_3'], $lancamento['saida_3']);
        $intervalo_4 = $this->calcularIntervaloNortuno($lancamento['entrada_4'], $lancamento['saida_4']);

        return $intervalo_1 + $intervalo_2 + $intervalo_3 + $intervalo_4;
    }

    private function calcularIntervalo($entrada, $saida){
        $inicio = $this->converterHoraEmDecimal($entrada);
        $fim = $this->converterHoraEmDecimal($saida);
    
        if(($inicio < $fim) || ($inicio ==0 && $fim == 0)){
            return $fim - $inicio;
        } else{
            return $fim - $inicio + 24;
        }
    }

    private function calcularIntervaloNortuno($entrada, $saida){
        $inicio = $this->converterHoraEmDecimal($entrada);
        $fim = $this->converterHoraEmDecimal($saida);
        $inicio2 = null;
        $fim2 = null;

        $inicioHoraNoturna = $this->converterHoraEmDecimal(Yii::$app->params['hr_inicio_hora_noturna']);
        $fimHoraNorturna = $this->converterHoraEmDecimal(Yii::$app->params['hr_fim_hora_noturna']);

        $horas_noturnas = null;

        if(($inicio == 0 && $fim == 0) 
            || ($inicio >= $fimHoraNorturna 
                && $inicio < $inicioHoraNoturna
                && $fim > $fimHoraNorturna
                && $fim <= $inicioHoraNoturna
                && $inicio < $fim)){
                    $horas_noturnas = 0;
        }else{
            if($inicio == $fim){
                $horas_noturnas = $fimHoraNorturna -  $inicioHoraNoturna;   
            } else{
                if($inicio > $fim){

                    if(($inicio <= $fimHoraNorturna && $fim < $fimHoraNorturna)
                        || $inicio > $inicioHoraNoturna && $fim >= $inicioHoraNoturna){

                            $fim = $fimHoraNorturna;
                            $inicio2 = $inicioHoraNoturna;
                            $fim2 = $fim;
                    }else{
                        if($inicio <= $inicioHoraNoturna){
                            $inicio = $inicioHoraNoturna; 
                        }
                        if($fim >= $fimHoraNorturna){
                            $fim = $fimHoraNorturna;
                        }
                    }
                }else{
                    if(!($inicio < $fimHoraNorturna && $fim <= $fimHoraNorturna)){
                        if(!($inicio > $inicioHoraNoturna && $fim > $inicioHoraNoturna)){
                            if($inicio < $fimHoraNorturna 
                                && $fim > $fimHoraNorturna
                                && $fim > $inicioHoraNoturna){
                                    $fim = $fimHoraNorturna;  
                            }else{
                                if($inicio < $inicioHoraNoturna
                                 && $inicio >= $fimHoraNorturna
                                 && $fim > $inicioHoraNoturna){
                                    $inicio = $inicioHoraNoturna;
                                }
                               
                            }
                        }
                    }

                    if($inicio < $fimHoraNorturna && $fim > $inicioHoraNoturna) {
                        $fim =  $fimHoraNorturna;
                        $inicio2 = $inicioHoraNoturna;
                        $fim2 = $fim;
                    }
                }
                $horas_noturnas = $fim - $inicio;
                if($inicio2 != null && $fim2 != null){
                    $horas_noturnas +=  ($fim2 - $inicio2);
                }
            }
        }
        if($horas_noturnas < 0) {
            $horas_noturnas += 24;
        }
        
        return $horas_noturnas;
    }

    private function converterHoraEmDecimal($hora){
        if($hora != ''){
            $array_hour = explode(":", $hora);
            return round(intval($array_hour[0]) + doubleval($array_hour[1] / 60), 2);
        } else {
            return 0;
        }
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

            
            for($i = 0; $i <= $intervalo->days; $i++){

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
