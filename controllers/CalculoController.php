<?php

namespace app\controllers;

use Yii;
use app\models\service\CalculoService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PreCalculoRecord;
use app\exceptions\PreCalculoNaoIniciadoException;
use app\util\MessageUtil;

class CalculoController extends ControllerTrait
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Retorna o service deste controller
     * @return CalculoService
     */
    private function getService(){
        return new CalculoService();
    }

    /**
     * Creates a new FeriadoRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionPreCalculo()
    {
        $retorno = $this->getService()->preCalculo();
        
        return $this->render('pre-calculo', [
            'model' => $retorno->getData()
        ]); 
    }

    public function actionCalculo(){

        try{
            $retorno = $this->getService()->calculo();
            $data = $retorno->getData();

            return $this->render('calculo', [
                'preCalculo' => $data["preCalculo"],
                'horasLancadas' => $data["horasLancadas"],
                'anosTrabalhados' => $data["anosTrabalhados"],
            ]);
        }catch(PreCalculoNaoIniciadoException $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE7"));

            return $this->redirect(['pre-calculo']);
        }
    }

    public function actionProcessarHoras(){

        return $this->getService()->processarHoras();

    }
    
}
