<?php
namespace app\util;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Classe responsável por armazenar o retorno da manipulação de dados
 * 
 * @author tulio
 */
class MessageResponse {
    
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const ERROR = 'danger';
    const INFO = 'info';

    private $success = true;
    private $messages = array();
    private $typeMessage = self::SUCCESS;
    private $data = null;
    
    function getSuccess() {
        return $this->success;
    }

    function getMessage() {
        return $this->messages;
    }

    function getTypeMessage() {
        return $this->typeMessage;
    }

    function getData() {
        return $this->data;
    }

    function setSuccess($success) {
        if(!is_bool($success)){
            throw new \Exception("O atributo precisar ser um boolean válido.");   
        }
        $this->success = $success;
    }

    function addMessage($message) {
        if(!is_string($message)){
            throw new \Exception("O atributo precisar ser uma string válida.");   
        }
        $this->messages[] = $message;
    }

    function resetMessages(){
        $this->messages = array();
    }
    
    function jsonMessages(){
        return json_encode($this->messages);
    }
            
    function setTypeMessage($typeMessage) {
        if($typeMessage !== self::SUCCESS &&
            $typeMessage !== self::WARNING &&
            $typeMessage !== self::ERROR &&
            $typeMessage !== self::INFO){
            throw new \Exception("Tipo de mensagem inesperada.");   
        }
        $this->typeMessage = $typeMessage;
    }

    function setData($data) {
        $this->data = $data;
    }

}
