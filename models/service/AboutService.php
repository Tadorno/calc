<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use\app\util\MessageResponse;
/**
 * Description of AboutService
 *
 * @author tulio
 */
class AboutService extends ServiceTrait{
    
    public function teste($data){
        $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
        $this->getRetorno()->addMessage("Teste Service");
        $this->getRetorno()->addMessage("Teste Service2");
        $this->getRetorno()->setData(array("túlio"));
        
        return $this->getRetorno();
    }
}
