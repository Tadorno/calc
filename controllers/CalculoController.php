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
                'horasParaLancamento' => $data["horasParaLancamento"],
                'anosTrabalhados' => $data["anosTrabalhados"],
                'mesesTrabalhadosNoAno' => $data["mesesTrabalhadosNoAno"],
                'anoPaginado' => $data["anoPaginado"],
                'mesPaginado' => $data["mesPaginado"]
            ]);
        }catch(PreCalculoNaoIniciadoException $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE7"));

            return $this->redirect(['pre-calculo']);
        }
    }

    public function actionProcessarHoras(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            return $this->getService()->processarHoras();
        }
    }

    public function actionMudarAbaLancamentoHoras(){
        try{
            $retorno = $this->getService()->mudarAba();
            $data = $retorno->getData();

            return $this->renderPartial('_lancamento_horas', [
                'horasParaLancamento' => $data["horasParaLancamento"],
                'anosTrabalhados' => $data["anosTrabalhados"],
                'mesesTrabalhadosNoAno' => $data["mesesTrabalhadosNoAno"],
                'anoPaginado' => $data["anoPaginado"],
                'mesPaginado' => $data["mesPaginado"]
            ]);
        }catch(\Exception $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE1"));

            return $this->redirect(['pre-calculo']);
        }
    }
    
}
