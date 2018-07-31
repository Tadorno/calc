<?php
namespace app\models\service;

use app\util\MessageResponse;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Classe pai para os Services do sistema
 *
 * @author tulio
 */
class ServiceTrait {
    private $retorno;
    
    public function __construct() {
        $this->retorno = new MessageResponse();
    }
    
    protected function getRetorno() {
        return $this->retorno;
    }

}
