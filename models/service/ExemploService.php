<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use Yii;
use\app\util\MessageResponse;
use app\models\ExemploRecord;
use \app\util\MessageUtil;
use \yii\web\NotFoundHttpException;
/**
 * Description of ExemploService
 *
 * @author tulio
 */
class ExemploService extends ServiceTrait{
    
    public function persist($id = null){
        $model = new ExemploRecord();
        
        try{
            if(!empty($id)){
                $model = $this->findModel($id);
            }
            /*
             * Independente do resultado, devolve o modelo
             */
            $this->getRetorno()->setData($model);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGS1"));
            } else {
                $this->getRetorno()->setSuccess(false);
            }
        }catch(\Exception $e){
            $this->getRetorno()->setSuccess(false);
            $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGE1"));
        }
        return $this->getRetorno();
    }
    
    public function findById($id){
        try{
            $this->getRetorno()->setData($this->findModel($id));
        }catch(\Exception $e){
            $this->getRetorno()->setSuccess(false);
            $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGE2"));
        }
        return $this->getRetorno();
    }
    
    public function delete($id){
        try{
            $this->findModel($id)->delete();
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGS1"));
        }catch(\Exception $e){
            $this->getRetorno()->setSuccess(false);
            $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGE1"));
        }
        return $this->getRetorno();
    }
    
    /**
     * Finds the Exemplo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExemploRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    private function findModel($id)
    {
        if (($model = ExemploRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(MessageUtil::getMessage("MSGE2"));
        }
    }
}
