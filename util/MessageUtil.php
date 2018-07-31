<?php
namespace app\util;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageUtil
 *
 * @author tulio
 */
class MessageUtil {
    //put your code here
    private static $msg = array(
        //Sucesso MSGS
        'MSGS1'=>'Operação realizada com sucesso!',
        
        //Alerta MSGA
        'MSGA1'=>'Usuário não encontrado ou senha incorreta!',
        'MSGA2'=>'Usuário desativado no sistema.',
        'MSGA3'=>'Favor preencher os campos obrigatórios.',
        
        //Info MSGI
        
        //Error MSGE
        'MSGE1'=>'Ocorreu um erro em sua requisição.',
        'MSGE2'=>'Não foi possível realizar esta consulta.',
    );
    
    public static function getMessage($key){
        if(isset(self::$msg[$key])){
            return utf8_encode(self::$msg[$key]);
        }
        throw new \Exception("Chave inexistente."); 
    }
}
