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

    public static function getDiaDaSemana(\DateTime $date){
        $diaDaSemana = $date->format('D');
        return DateUtil::semana["$diaDaSemana"];
    }

    public static function strToDate($strDate){

        $date = explode("/", $strDate);

        return new \DateTime($date[2].'-'.$date[1].'-'.$date[0], new \DateTimeZone('UTC'));
    }
}