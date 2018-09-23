<?php


namespace app\models\service;

use app\util\DateUtil;
use Yii;

/**
 * Description of ApuracaoService
 *
 * @author tulio
 */
class ApuracaoService{

    private $resumoHorasService;

    public function __construct(){
        $this->resumoHorasService = new ResumoHorasService();    
    }

    /**
     * Calcula a apuração dos dados informados
     */
    public function calcularApuracao($lancamentoJson){
        $apuracao = array();

        foreach($lancamentoJson as $anoKey => $anoValues){
            foreach($anoValues as $mesKey => $mesValues){
                $apuracao[$anoKey][$mesKey] = [
                    'Sun' => 0,
                    'Mon' => 0,
                    'Tue' => 0,
                    'Wed' => 0,
                    'Thu' => 0,
                    'Fri' => 0,
                    'Sat' => 0,
                    'feriado' =>  0,
                    'dias_uteis' => 0
                ];
                foreach($mesValues as $diaKey => $lancamento){
                    $resumoDia = $this->resumoHorasService->calcularResumoHoraDia($lancamento);
                    $apuracao[$anoKey][$mesKey] = $this->calcularApuracaoDia($apuracao[$anoKey][$mesKey], $resumoDia);    
                }
            }  
        }

        return $apuracao;
    }

    /**
     * Condensa a apuração diária
     */
    private function calcularApuracaoDia($apuracao, $resumoDia){

        $date = DateUtil::strToDate($resumoDia['data']);
        $diasUteis = Yii::$app->params['dias_uteis'];

        if(in_array($date->format('N'), $diasUteis)){
            $apuracao['dias_uteis']++;
        }

        if(intval($resumoDia['horas_trabalhadas']) > 0){
            $apuracao[$date->format('D')] += 1;   
        }
        
        return $apuracao;
    }

}