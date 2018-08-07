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
        'MSGA1'=>'Deseja realmente excluir este item?',
        
        //Info MSGI
        
        //Error MSGE
        'MSGE1'=>'Ocorreu um erro em sua requisição.',
        'MSGE2'=>'Não foi possível realizar esta consulta.',
        'MSGE3'=>'Campo obrigatório.',
        'MSGE4'=>'Nome já cadastrado.',
        'MSGE5'=>'Valor inválido.',
        'MSGE6'=>'Item não encontrado.',
        'MSGE7'=>'Pré-cálculo não iniciado.',
        'MSGE8'=>'Data de Prescrição ou de Admissão não pode ser maior que a Data de Afastamento.',
    );
    
    public static function getMessage($key){
        if(isset(self::$msg[$key])){
            return self::$msg[$key];
        }
        throw new \Exception("Chave inexistente."); 
    }
}
