<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use app\models\PreCalculoRecord;
use \yii\web\NotFoundHttpException;
use \app\util\MessageUtil;
/**
 * Description of CalculoService
 *
 * @author tulio
 */
class CalculoService extends ServiceTrait{
    
    protected function getModel(){
        return $model = new PreCalculoRecord();
    }
    
    protected function findModel($id)
    {
        if (($model = PreCalculoRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(MessageUtil::getMessage("MSGE6"));
        }
    }

    public function preCalculo($id = null){
        $this->getRetorno()->setData(new PreCalculoRecord());
        
        return $this->getRetorno();
    }
}
