<?php


namespace app\models\service;

use app\util\HoraUtil;
use Yii;

/**
 * Description of ResumoHorasService
 *
 * @author tulio
 */
class ResumoHorasService{

    /**
     * Calcula o resumo no período informado
     */
    public function calcularResumoHoras($lancamentoJson){
        $resumoHoras = array();
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

                foreach($mesValues as $diaKey => $lancamento){
                    $resumoHoras[$anoKey][$mesKey][$diaKey] = $this->calcularResumoHoraDia($lancamento);
                    
                    $totalizadorMes = $this->totalizadorDeMes($totalizadorMes, $resumoHoras[$anoKey][$mesKey][$diaKey], $anoKey, $mesKey);
                    $totalizadorAno = $this->totalizadorDeAnos($totalizadorAno, $resumoHoras[$anoKey][$mesKey][$diaKey], $anoKey);
                  
                }
                $resumoHoras[$anoKey][$mesKey]['total'] = $totalizadorMes;
            }
            $resumoHoras[$anoKey]['total'] = $totalizadorAno;
        }

        return $resumoHoras;
    }

    /**
     * Calculao resumo diário
     */
    public function calcularResumoHoraDia($lancamento){
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

    /**
     * Calcula o totalizador Mensal
     */
    private function totalizadorDeMes($totalizador, $resumoDiario, $anoKey, $mesKey){
        $totalizador['horas_trabalhadas'] += $resumoDiario['horas_trabalhadas'];
        $totalizador['horas_noturnas'] += $resumoDiario['horas_noturnas'];
        $totalizador['horas_diurnas'] += $resumoDiario['horas_diurnas'];

        return $totalizador;
    }

    /**
     * Calcula o Totalizador Anual
     */
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
        $inicio = HoraUtil::converterHoraEmDecimal($entrada);
        $fim = HoraUtil::converterHoraEmDecimal($saida);
    
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
        $inicio = HoraUtil::converterHoraEmDecimal($entrada);
        $fim = HoraUtil::converterHoraEmDecimal($saida);
        $inicio2 = null;
        $fim2 = null;

        $inicioHoraNoturna = HoraUtil::converterHoraEmDecimal(Yii::$app->params['periodo_noturno']['hr_inicio_hora_noturna']);
        $fimHoraNorturna = HoraUtil::converterHoraEmDecimal(Yii::$app->params['periodo_noturno']['hr_fim_hora_noturna']);

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
}