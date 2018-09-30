<?php


namespace app\models\service;

use app\util\HoraUtil;
use app\util\DateUtil;
use app\enum\DiaEnum;
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
        $limiteCargaHoraria = Yii::$app->params['limite_carga_horaria'];
        $limiteMensal = $limiteCargaHoraria['mensal'];
        $limiteAnual = $limiteCargaHoraria['anual'];

        $resumoHoras = array();
        $horas_semanais = 0;
        $horas_mensais = 0;

        foreach($lancamentoJson as $anoKey => $anoValues){
            $totalizadorAno = [
                'horas_trabalhadas' => 0,
                'horas_noturnas' => 0,
                'horas_diurnas' => 0,
                'horas_extras' => 0
            ];
            foreach($anoValues as $mesKey => $mesValues){
                $totalizadorMes = [
                    'horas_trabalhadas' => 0,
                    'horas_noturnas' => 0,
                    'horas_diurnas' => 0,
                    'horas_extras' => 0
                ];

                foreach($mesValues as $diaKey => $lancamento){
                    //Calcula o resumo de horas (horas trabalhadas, norturnas e diária)
                    $resumoHoras[$anoKey][$mesKey][$diaKey] = $this->calcularResumoHoraDia($lancamento);
                    
                    //Calcula a hora extra diária semanal e mensal
                    $horas_extras =  $this->calcularHorasExtras($resumoHoras[$anoKey][$mesKey][$diaKey], $horas_semanais);

                    $resumoHoras[$anoKey][$mesKey][$diaKey]['horas_extras'] = $horas_extras;

                    //Calcula os totalizadores por mes/ano
                    $totalizadorMes = $this->totalizadorDeMes($totalizadorMes, $resumoHoras[$anoKey][$mesKey][$diaKey], $anoKey, $mesKey);
                    $totalizadorAno = $this->totalizadorDeAnos($totalizadorAno, $resumoHoras[$anoKey][$mesKey][$diaKey], $anoKey);
                  
                }

                $totalizadorMes['horas_extras'] = $totalizadorMes['horas_trabalhadas'] > $limiteMensal ? $totalizadorMes['horas_trabalhadas'] - $limiteMensal : 0;
                
                $resumoHoras[$anoKey][$mesKey]['total'] = $totalizadorMes;
            }

            $totalizadorAno['horas_extras'] = $totalizadorAno['horas_trabalhadas'] > $limiteAnual ? $totalizadorAno['horas_trabalhadas'] - $limiteAnual : 0;

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

        return [
            'data' => $lancamento['data'],
            'dia_da_semana' => $lancamento['dia_da_semana'],
            'horas_trabalhadas' => $horas_trabalhadas,
            'horas_noturnas' => $horas_noturnas,
            'horas_diurnas' => $horas_diurnas
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
    private function calcularHorasExtras($resumoDia, &$horas_semanais){
        $limiteCargaHoraria = Yii::$app->params['limite_carga_horaria'];
        $limiteSemanal = $limiteCargaHoraria['semanal'];
        $ultimoDiaDaSemana = $limiteCargaHoraria['ultimo_dia'];
        $date = DateUtil::strToDate($resumoDia['data']);

        $limiteCargaDia = HoraUtil::converterHoraEmDecimal($limiteCargaHoraria[$date->format('D')]);
        
        //Verifica se o dia a ser calculado é o ultimo dia da semana
        if($date->format('N') != $ultimoDiaDaSemana){
            //Calcula a hora extra do dia
            $extra_diaria = $resumoDia['horas_trabalhadas'] <= $limiteCargaDia ? 0 : $resumoDia['horas_trabalhadas'] - $limiteCargaDia;
            
            //Incrementa a hora trabalhada da semana com a hora do dia, caso a hora do dia seja superior
            // ao limite diário, usa o limite diário
            $horas_semanais += $resumoDia['horas_trabalhadas'] > $limiteCargaDia ? $limiteCargaDia : $resumoDia['horas_trabalhadas'];
            
            return $extra_diaria;
        }else{
            $horas_semanais += $resumoDia['horas_trabalhadas'];

            $extra_semanal = $horas_semanais <= $limiteSemanal ? 0 : $horas_semanais - $limiteSemanal;
            
            $horas_semanais = 0;
        
            return $extra_semanal;
        }
 
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