<?php
namespace app\util;

/**
 * Classe responsável por armazenar o retorno da manipulação de dados
 * 
 * @author tulio
 */
class DateUtil {

    const semana = array(
        'Sun' => 'Domingo', 
        'Mon' => 'Segunda',
        'Tue' => 'Terça',
        'Wed' => 'Quarta',
        'Thu' => 'Quinta',
        'Fri' => 'Sexta',
        'Sat' => 'Sábado'
    );
    
    const mes_extenso = array(
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Marco',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Sep' => 'Setembro',
        'Oct' => 'Outubro',
        'Nov' => 'Novembro',
        'Dec' => 'Dezembro'
    );

    const mes_ptBR = array(
        '01' => 'Jan',
        '02' => 'Fev',
        '03' => 'Mar',
        '04' => 'Abr',
        '05' => 'Mai',
        '06' => 'Jun',
        '07' => 'Jun',
        '08' => 'Ago',
        '09' => 'Set',
        '10' => 'Out',
        '11' => 'Nov',
        '12' => 'Dez'
    );

    public static function getDiaDaSemana(\DateTime $date){
        $diaDaSemana = $date->format('D');
        return DateUtil::semana["$diaDaSemana"];
    }

    public static function strToDate($strDate){

        $date = explode("/", $strDate);

        return new \DateTime($date[2].'-'.$date[1].'-'.$date[0], new \DateTimeZone('UTC'));
    }
}