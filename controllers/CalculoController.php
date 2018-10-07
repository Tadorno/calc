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
                'resumoHoras' => $data["resumoHoras"],
                'apuracao' => $data["apuracao"],
                'mainTab' => 'tab-lancamento-hora',
                'tabLancamento' => $data["anoPaginado"],
                'remuneracaoPage' => $data["remuneracaoPage"]
            ]);
        }catch(PreCalculoNaoIniciadoException $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE7"));

            return $this->redirect(['pre-calculo']);
        }
    }
    
    public function actionManterAbaApuracao(){
        try{
            
            $retorno = $this->getService()->processarManterApuracao();
            $data = $retorno->getData();

            return $this->renderPartial('apuracao/_apuracao', [  
                'anosTrabalhados' => $data["anosTrabalhados"],
                'apuracao' => $data['apuracao']
            ]);

        }catch(\Exception $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE1"));
            print_r($e);
            return $this->redirect(['pre-calculo']);
        }
    }

    public function actionManterAbaResumo(){
        try{
            
            $retorno = $this->getService()->processarResumoHoras();
            $data = $retorno->getData();

            return $this->renderPartial('lancamento-horas/_resumo_horas', [  
                'resumoHoras' => $data["resumoHoras"]
            ]);

        }catch(\Exception $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE1"));
            print_r($e);
            return $this->redirect(['pre-calculo']);
        }
    }

    public function actionMudarAbaRemuneracao(){
        try{
            $retorno = $this->getService()->mudarAbaRemuneracao();
            $data = $retorno->getData();
 
            return $this->renderPartial('remuneracao/_remuneracao', [
                'remuneracaoPage' => $data['remuneracaoPage'],
                'anosTrabalhados' => $data["anosTrabalhados"],
                'anoPaginado' => $data["anoPaginado"]
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
                'mesPaginado' => $data["mesPaginado"],
                'tabLancamento' => $data['tabLancamento'],
                'resumoHoras' => $data['resumoHoras']
            ]);
        }catch(\Exception $e){
            $this->addErrorMessage(MessageUtil::getMessage("MSGE1"));
            print_r($e);
            return $this->redirect(['pre-calculo']);
        }
    }
    
}
