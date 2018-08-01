<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use app\models\FeriadoRecord;
use \yii\web\NotFoundHttpException;
use \app\util\MessageUtil;
/**
 * Description of FeriadoService
 *
 * @author tulio
 */
class FeriadoService extends ServiceTrait{
    
    protected function getModel(){
        return $model = new FeriadoRecord();
    }
    
    protected function findModel($id)
    {
        if (($model = FeriadoRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(MessageUtil::getMessage("MSGE6"));
        }
    }
}
