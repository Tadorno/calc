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

    private $apuracaoService;
    private $resumoService;

    public function __construct(){
        parent::__construct();

        $this->apuracaoService = new ApuracaoService();  
        $this->resumoService = new ResumoHorasService(); 
    }
    
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
            $resumo = $this->resumoService->calcularResumoHoras($lancamentoJson);
            $apuracao = $this->apuracaoService->calcularApuracao($lancamentoJson);

            $this->getRetorno()->setData([
                'preCalculo' => $preCalculo,
                'horasParaLancamento' => current(current($dadosDeLancamento)), //Retorna o primeiro mês do
                'anosTrabalhados' => array_keys($dadosDeLancamento),
                'mesesTrabalhadosNoAno' => array_keys(current($dadosDeLancamento)),
                'anoPaginado' => array_keys($dadosDeLancamento)[0],
                'mesPaginado' => key(current($dadosDeLancamento)),
                'resumoHoras' => $resumo,
                'apuracao' => $apuracao
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

                $resumo = $this->resumoService->calcularResumoHoras($lancamentoJson);

                $this->getRetorno()->setData([
                    'horasParaLancamento' => $lancamentoJson[$post['ano']][$mes], //Retorna o primeiro mês do
                    'anosTrabalhados' => array_keys($lancamentoJson),
                    'mesesTrabalhadosNoAno' => array_keys($lancamentoJson[$post['ano']]),
                    'anoPaginado' => $post['ano'],
                    'mesPaginado' => $mes,
                    'tabLancamento' => $post['tabLancamento'],
                    'resumoHoras' => $resumo
                ]);
                
            }else {
                throw new \Exception("Erro ao modificar arquivo de lançamento");
            }

            return $this->getRetorno();
        }
    }
    
    public function processarManterApuracao(){
        $post = Yii::$app->request->post();

        if($post){
            $lancamentoJson = $this->atualizarJsonLancamento($this->getLancamentoJson(), $post);
        
            if($this->setLancamentoJson($lancamentoJson)) {
                $apuracao = $this->apuracaoService->calcularApuracao($lancamentoJson);
                
                $this->getRetorno()->setData([
                    'anosTrabalhados' => array_keys($lancamentoJson),
                    'apuracao' => $apuracao
                ]);
            }

            return $this->getRetorno();
        }
    }

    public function processarResumoHoras(){
         
        $post = Yii::$app->request->post();

        if($post){

            $lancamentoJson = $this->atualizarJsonLancamento($this->getLancamentoJson(), $post);

            if($this->setLancamentoJson($lancamentoJson)) {

                $resumo = $this->resumoService->calcularResumoHoras($lancamentoJson);

                $this->getRetorno()->setData([
                    'resumoHoras' => $resumo
                ]);

                return $this->getRetorno();
            }else {
                throw new \Exception("Erro ao modificar arquivo de lançamento");
            }
        }
        
    }

    /**
     * Atualiza o json com os dados de entrada paginado
     */
    private function atualizarJsonLancamento($json, $post){
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

    /**
     * Retorna o Json a ser trabalhado
     */
    private function getLancamentoJson(){
        $jsonFile = Yii::$app->basePath . "/tmp/tmp.json";

        return json_decode(file_get_contents(Yii::$app->basePath . "/tmp/tmp.json"), true);
    }

    /**
     * Salva o json e retorna true se não houve erros
     */
    private function setLancamentoJson($lancamentoJson){
        $jsonFile = Yii::$app->basePath . "/tmp/tmp.json";

        return file_put_contents($jsonFile, json_encode($lancamentoJson));
    }

    /**
     * Preenche um lançamento diário
     */
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