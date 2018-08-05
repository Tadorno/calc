<?php
namespace app\models\service;

use app\util\MessageResponse;
use \yii\web\NotFoundHttpException;
use app\util\EncrypterUtil;
use app\util\MessageUtil;
use Yii;

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
abstract class ServiceTrait {
    private $retorno;
    
    public function __construct() {
        $this->retorno = new MessageResponse();
    }
    
    protected function getRetorno() {
        return $this->retorno;
    }

    public function persist($id = null){
        $model = $this->getModel();
        
        try{
            if(!empty($id)){
                $model = $this->findModel(EncrypterUtil::decrypt($id));
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
        }catch(NotFoundHttpException $e){
            $this->getRetorno()->setSuccess(false);
            $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGE6"));
        }catch(\Exception $e){
            $this->getRetorno()->setSuccess(false);
            $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGE1"));
            $this->getRetorno()->setData($model);
        }
        return $this->getRetorno();
    }

    public function findById($id){
        try{
            $this->getRetorno()->setData($this->findModel(EncrypterUtil::decrypt($id)));
        }catch(NotFoundHttpException $e){
            $this->getRetorno()->setSuccess(false);
            $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGE6"));
        }catch(\Exception $e){
            $this->getRetorno()->setSuccess(false);
            $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGE2"));
        }
        return $this->getRetorno();
    }

    public function delete($id){
        try{
            $this->findModel(EncrypterUtil::decrypt($id))->delete();
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGS1"));
        }catch(NotFoundHttpException $e){
            $this->getRetorno()->setSuccess(false);
            $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGE6"));
        }catch(\Exception $e){
            $this->getRetorno()->setSuccess(false);
            $this->getRetorno()->setTypeMessage(MessageResponse::ERROR);
            $this->getRetorno()->addMessage(MessageUtil::getMessage("MSGE1"));
        }
        return $this->getRetorno();
    }

    protected abstract function getModel();

    protected abstract function findModel($id);
}
