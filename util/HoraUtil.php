<?php
namespace app\util;

/**
 * Classe responsável pela manipulação da hora
 * 
 * @author tulio
 */
class HoraUtil {

    /**
     * Converte uma hora no formato hh:mm para seu correspondente em horas decimais
     */
    public static function converterHoraEmDecimal($hora){
        if($hora != ''){
            $array_hour = explode(":", $hora);

            $h = str_replace('h', '0', $array_hour[0]);
            $m = str_replace('m', '0', $array_hour[1]);
            return round(intval($h) + doubleval($m / 60), 2);
        } else {
            return 0;
        }
    }
}