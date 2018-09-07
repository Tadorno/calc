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
use yii\web\Cookie;
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

            //Armazena localmente o arquivo json para melhorar a performance para grandes períodos
            $lancamentoJson = fopen(Yii::$app->basePath . "/tmp/tmp.json", "w");
            fwrite($lancamentoJson, json_encode($dadosDeLancamento));
            fclose($lancamentoJson);

            $lancamentoJson = $this->getLancamentoJson();
            $processamento = $this->calcularResumoApuracao($lancamentoJson);

            $this->getRetorno()->setData([
                'preCalculo' => $preCalculo,
                'horasParaLancamento' => current(current($dadosDeLancamento)), //Retorna o primeiro mês do
                'anosTrabalhados' => array_keys($dadosDeLancamento),
                'mesesTrabalhadosNoAno' => array_keys(current($dadosDeLancamento)),
                'anoPaginado' => array_keys($dadosDeLancamento)[0],
                'mesPaginado' => key(current($dadosDeLancamento)),
                'resumoHoras' => $processamento['resumoHoras'],
                'apuracao' => $processamento['apuracao']
            ]);
        } else {
            throw new PreCalculoNaoIniciadoException("Pré calculo é obrigatório");
        }
        return $this->getRetorno();
    }

    public function mudarAba(){

        $post = Yii::$app->request->post();

        if($post){

            $lancamentoJson = $this->atualizarJsonLancamento($this->getLancamentoJson(), $post);

            if($this->setLancamentoJson($lancamentoJson)) {
                $mes = $post['mes'] != null ? $post['mes'] : key($lancamentoJson[$post['ano']]);

                $processamento = calcularResumoApuracao($lancamentoJson);

                $this->getRetorno()->setData([
                    'horasParaLancamento' => $lancamentoJson[$post['ano']][$mes], //Retorna o primeiro mês do
                    'anosTrabalhados' => array_keys($lancamentoJson),
                    'mesesTrabalhadosNoAno' => array_keys($lancamentoJson[$post['ano']]),
                    'anoPaginado' => $post['ano'],
                    'mesPaginado' => $mes,
                    'tabLancamento' => $post['tabLancamento'],
                    'resumoHoras' => $processamento['resumoHoras']
                ]);
                
            }else {
                throw new \Exception("Erro ao modificar arquivo de lançamento");
            }

            return $this->getRetorno();
        }
    }

    public function atualizarJsonLancamento($json, $post){
        //Atualiza o Json com o resultado inputado
        $ano = $post['anoPaginado'];
        $mes = $post['mesPaginado'];

        foreach($json[$ano][$mes] as $key => $lancamento){
            $json[$ano][$mes][$key]['entrada_1'] 
                = $post['LancamentoHoraRecord'][$key]['entrada_1'];
            $json[$ano][$mes][$key]['entrada_2'] 
                = $post['LancamentoHoraRecord'][$key]['entrada_2'];
            $json[$ano][$mes][$key]['entrada_3'] 
                = $post['LancamentoHoraRecord'][$key]['entrada_3'];
            $json[$ano][$mes][$key]['entrada_4'] 
                = $post['LancamentoHoraRecord'][$key]['entrada_4'];

            $json[$ano][$mes][$key]['saida_1'] 
                = $post['LancamentoHoraRecord'][$key]['saida_1'];
            $json[$ano][$mes][$key]['saida_2']
                = $post['LancamentoHoraRecord'][$key]['saida_2'];
            $json[$ano][$mes][$key]['saida_3'] 
                = $post['LancamentoHoraRecord'][$key]['saida_3'];
            $json[$ano][$mes][$key]['saida_4'] 
                = $post['LancamentoHoraRecord'][$key]['saida_4'];
        }

        return $json;
    }
    

    public function processarHoras(){
         
        $post = Yii::$app->request->post();

        if($post){
            
            $preCalculo = new PreCalculoRecord();
            $preCalculo->load(Yii::$app->request->post());

            $lancamentoJson = $this->atualizarJsonLancamento($this->getLancamentoJson(), $post);

            if($this->setLancamentoJson($lancamentoJson)) {

                $processamento = $this->calcularResumoApuracao($lancamentoJson);

                $this->getRetorno()->setData([
                    'horasParaLancamento' => $lancamentoJson[$post['anoPaginado']][$post['mesPaginado']], //Retorna o primeiro mês do
                    'anosTrabalhados' => array_keys($lancamentoJson),
                    'mesesTrabalhadosNoAno' => array_keys($lancamentoJson[$post['anoPaginado']]),
                    'anoPaginado' => $post['anoPaginado'],
                    'mesPaginado' => $post['mesPaginado'],
                    'preCalculo' => $preCalculo,
                    'resumoHoras' => $processamento['resumoHoras'],
                    'apuracao' => $processamento['apuracao'],
                    'mainTab' => $post['main-tab'],
                    'tabLancamento' => $post['tabLancamento']
                ]);

                return $this->getRetorno();
            }else {
                throw new \Exception("Erro ao modificar arquivo de lançamento");
            }
        }
        
    }

    private function calcularResumoApuracao($lancamentoJson){
        $resumoHoras = array();
        $apuracao = array();
        foreach($lancamentoJson as $anoKey => $anoValues){
            $totalizadorAno = [
                'horas_trabalhadas' => 0,
                'horas_noturnas' => 0,
                'horas_diurnas' => 0
            ];
            foreach($anoValues as $mesKey => $mesValues){
                $totalizadorMes = [
                    'horas_trabalhadas' => 0,
                    'horas_noturnas' => 0,
                    'horas_diurnas' => 0
                ];

                $apuracao[$anoKey][$mesKey] = [
                    'domingo' => 0,
                    'seg_sexta' => 0,
                    'sabado' => 0,
                    'feriado' =>  0,
                    'dias_uteis' => 0
                ];

                foreach($mesValues as $diaKey => $lancamento){
                    $resumoHoras[$anoKey][$mesKey][$diaKey] = $this->calcularResumoHora($lancamento);

                    $totalizadorMes = $this->totalizadorDeMes($totalizadorMes, $resumoHoras[$anoKey][$mesKey][$diaKey], $anoKey, $mesKey);
                    $totalizadorAno = $this->totalizadorDeAnos($totalizadorAno, $resumoHoras[$anoKey][$mesKey][$diaKey], $anoKey);
                  
                    $apuracao[$anoKey][$mesKey] = $this->calcularApuracao($apuracao[$anoKey][$mesKey], $resumoHoras[$anoKey][$mesKey][$diaKey]);
                }
                $resumoHoras[$anoKey][$mesKey]['total'] = $totalizadorMes;
            }
            $resumoHoras[$anoKey]['total'] = $totalizadorAno;
        }

        return [
            'resumoHoras' => $resumoHoras,
            'apuracao' => $apuracao
        ];
    }

    private function calcularResumoHora($lancamento){
        $horas_trabalhadas = $this->calcularHorasTrabalhadas($lancamento);
        $horas_noturnas =  $this->calcularHorasNoturnas($lancamento);
        $horas_diurnas = $horas_trabalhadas - $horas_noturnas;
        $horas_extras =  $this->calcularHorasExtras($lancamento);  

        return [
            'data' => $lancamento['data'],
            'dia_da_semana' => $lancamento['dia_da_semana'],
            'horas_trabalhadas' => $horas_trabalhadas,
            'horas_noturnas' => $horas_noturnas,
            'horas_diurnas' => $horas_diurnas,
            'horas_extras' => $horas_extras
        ];
    }

    private function calcularApuracao($apuracao, $resumoDia){
        $date = DateUtil::strToDate($resumoDia['data']);
        $diasUteis = Yii::$app->params['dias_uteis'];

        if(in_array($date->format('N'), $diasUteis)){
            $apuracao['dias_uteis']++;
        }

        if($date->format('l') == 'Sunday'){
            $apuracao['domingo'] += $resumoDia['horas_trabalhadas'];
        } elseif($date->format('l') == 'Saturday'){
            $apuracao['sabado'] += $resumoDia['horas_trabalhadas'];
        } else{
            $apuracao['seg_sexta'] += $resumoDia['horas_trabalhadas'];
        }

        return $apuracao;
    }

    private function totalizadorDeMes($totalizador, $resumoDiario, $anoKey, $mesKey){
        $totalizador['horas_trabalhadas'] += $resumoDiario['horas_trabalhadas'];
        $totalizador['horas_noturnas'] += $resumoDiario['horas_noturnas'];
        $totalizador['horas_diurnas'] += $resumoDiario['horas_diurnas'];

        return $totalizador;
    }

    private function totalizadorDeAnos($totalizador, $resumoDiario, $anoKey){
        $totalizador['horas_trabalhadas'] += $resumoDiario['horas_trabalhadas'];
        $totalizador['horas_noturnas'] += $resumoDiario['horas_noturnas'];
        $totalizador['horas_diurnas'] += $resumoDiario['horas_diurnas'];

        return $totalizador;
    }

    /**
     * Calcula as horas extras de um dia lançado
     */
    private function calcularHorasExtras($horasTrabalhadas){
        $horasSemanais = Yii::$app->params['horas_semanais'];
        //$horasDiarias = $horasSemanais
    }

    /**
     * Calcula o somatório dos intervalos de horas informados 
     */
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

    /**
     * Calcula o intervalo entre duas horas para o cálculo trabalhista
     */
    private function calcularIntervalo($entrada, $saida){
        $inicio = $this->converterHoraEmDecimal($entrada);
        $fim = $this->converterHoraEmDecimal($saida);
    
        if(($inicio < $fim) || ($inicio ==0 && $fim == 0)){
            return $fim - $inicio;
        } else{
            return $fim - $inicio + 24;
        }
    }

    /**
     * Calcular o intervalo noturno entre duas horas
     */
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

    /**
     * Converte uma hora no formato hh:mm para seu correspondente em horas decimais
     */
    private function converterHoraEmDecimal($hora){
        if($hora != ''){
            $array_hour = explode(":", $hora);

            $h = str_replace('h', '0', $array_hour[0]);
            $m = str_replace('m', '0', $array_hour[1]);
            return round(intval($h) + doubleval($m / 60), 2);
        } else {
            return 0;
        }
    }

    private function montarCamposParaLancamentoDeHoras(PreCalculoRecord $preCalculo){
        $dataAdmissao = DateUtil::strToDate($preCalculo->dt_admissao);
        $dataAfastamento = DateUtil::strToDate($preCalculo->dt_afastamento);
        $dataPrescricao = DateUtil::strToDate($preCalculo->dt_prescricao);

        $dataInicioContagem = $dataAdmissao < $dataPrescricao ? $dataPrescricao : $dataAdmissao;

        $horasParaLancamento = array();

        if($dataAfastamento >= $dataInicioContagem){
            $intervalo = $dataInicioContagem->diff($dataAfastamento);

            
            for($i = 0; $i <= $intervalo->days; $i++){

                if($i != 0){
                    $dataInicioContagem->add(new \DateInterval('P1D'));
                }

                $ano = $dataInicioContagem->format('Y');
                $mes = $dataInicioContagem->format('m');
                $dia = $dataInicioContagem->format('d');

                if(!array_key_exists($ano, $horasParaLancamento)){
                    $horasParaLancamento[$ano] = array();
                }

                if(!array_key_exists($mes, $horasParaLancamento[$ano])){
                    $horasParaLancamento[$ano][$mes] = array();
                }

                $horasParaLancamento[$ano][$mes][$dia] = $this->fillLancamento($dataInicioContagem);
            }
        }

        return $horasParaLancamento;
    }

    private function getLancamentoJson(){
        $jsonFile = Yii::$app->basePath . "/tmp/tmp.json";

        return json_decode(file_get_contents(Yii::$app->basePath . "/tmp/tmp.json"), true);
    }

    private function setLancamentoJson($lancamentoJson){
        $jsonFile = Yii::$app->basePath . "/tmp/tmp.json";

        return file_put_contents($jsonFile, json_encode($lancamentoJson));
    }

    private function fillLancamento($date){

        $lancamento = [

            'data' => $date->format('d/m/Y'),
            'entrada_1' => "",
            'saida_1' => "",
            'entrada_2' => "",
            'saida_2' => "",
            'entrada_3' => "",
            'saida_3' => "",
            'entrada_4' => "",
            'saida_4' => "",
            'horas_trabalhadas' => "",
            'horas_noturnas' => "",
            'horas_diurnas' => "",
            'dia_da_semana' => DateUtil::getDiaDaSemana($date),
            'dia' => $date->format('d'),
            'mes' => $date->format('M'),
            'ano' => $date->format('Y')
        ];

        return $lancamento;
    }

}