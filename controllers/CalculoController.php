<?php

namespace app\controllers;

use Yii;
use app\models\service\CalculoService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
    
}
