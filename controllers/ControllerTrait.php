<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use\app\util\MessageResponse;

/**
 * Description of Controller
 *
 * @author tulio
 */
class ControllerTrait extends Controller {
    
    public function getFromSession($key){
        $session = Yii::$app->session;
        if (!$session->isActive){
            $session->open(); 
        }
        if ($session->has($key)){
            return $session->get($key);
        }else{
            return null;
        }  
    }
    
    public function putOnSession($key, $value){
        $session = Yii::$app->session;
        if (!$session->isActive){
            $session->open(); 
        }
        $session->set($key, $value);
    }
       
    public function removeFromSession($key){
        $session = Yii::$app->session;
        if (!$session->isActive){
            $session->open(); 
        }
        if ($session->has($key)){
            $session->remove($key);
        }
    }

    public function addFlashMessage(MessageResponse $response){
        Yii::$app->session->setFlash($response->getTypeMessage(), $response->getMessages());
    }
}
