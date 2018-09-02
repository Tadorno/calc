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
                'mesPaginado' => $data["mesPaginado"],
                'resumoHoras' => [],
                'apuracao' => [],
                'mainTab' => 'tab-lancamento-hora'
            ]);
        }catch(PreCalculoNaoIniciadoException $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE7"));

            return $this->redirect(['pre-calculo']);
        }
    }

    public function actionProcessarHoras(){
        try{
            
            $retorno = $this->getService()->processarHoras();
            $data = $retorno->getData();

            return $this->renderPartial('_calculo_content', [
                'resumoHoras' => $data["resumoHoras"],
                'preCalculo' => $data["preCalculo"],
                'horasParaLancamento' => $data["horasParaLancamento"],
                'anosTrabalhados' => $data["anosTrabalhados"],
                'mesesTrabalhadosNoAno' => $data["mesesTrabalhadosNoAno"],
                'anoPaginado' => $data["anoPaginado"],
                'mesPaginado' => $data["mesPaginado"],
                'mainTab' => $data['mainTab'],
                'apuracao' => $data['apuracao'],
            ]);

        }catch(\Exception $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE1"));
            print_r($e);
            return $this->redirect(['pre-calculo']);
        }
    }

    public function actionMudarAbaLancamentoHoras(){
        try{
            $retorno = $this->getService()->mudarAba();
            $data = $retorno->getData();
 
            return $this->renderPartial('lancamento-horas/_lancamento_horas', [
                'horasParaLancamento' => $data["horasParaLancamento"],
                'anosTrabalhados' => $data["anosTrabalhados"],
                'mesesTrabalhadosNoAno' => $data["mesesTrabalhadosNoAno"],
                'anoPaginado' => $data["anoPaginado"],
                'mesPaginado' => $data["mesPaginado"]
            ]);
        }catch(\Exception $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE1"));
            print_r($e);
            return $this->redirect(['pre-calculo']);
        }
    }
    
}
