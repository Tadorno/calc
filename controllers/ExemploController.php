<?php

namespace app\controllers;

use Yii;
use app\models\search\ExemploSearch;
use yii\filters\VerbFilter;
use app\models\service\ExemploService;
use app\models\ExemploRecord;

/**
 * ExemploController implements the CRUD actions for Exemplo model.
 */
class ExemploController extends ControllerTrait
{
    /**
     * Retorna o service deste controller
     * @return ExemploService
     */
    private function getService(){
        return new ExemploService();
    }
    
    /**
     * @inheritdoc
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
     * Lists all Exemplo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExemploSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        /*
         * Coleta o retorno da sessão e o remove caso exista
         */
        $retorno = $this->getFromSession('return');
        if(!empty($retorno)){
            $this->removeFromSession('return');
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'return' => $retorno,
        ]);
    }

    /**
     * Displays a single Exemplo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /*
         * Coleta o retorno da sessão e o remove caso exista
         */
        $retorno = $this->getFromSession('return');
        if(!empty($retorno)){
            $this->removeFromSession('return');
        }else{
            $retorno = $this->getService()->findById($id);
        }
        
        return $this->render('view', [
            'return' => $retorno,
        ]);
    }

    /**
     * Creates a new Exemplo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $retorno = $this->getService()->persist();
        if($retorno->getSuccess()){
            /* 
            * Como não é possível enviar um objeto no redirect(), a solução adotada foi
            * armazenar o retorno na sessão para ser recuperado no action do index
            */
            $this->putOnSession('return', $retorno);
            
            $model = $retorno->getData();
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            return $this->render('create', [
                'return' => $retorno,
            ]);
        }
    }

    public function actionForm(){
        $model = new ExemploRecord();

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Exemplo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $retorno = $this->getService()->persist($id);
        if($retorno->getSuccess()){
            /* 
            * Como não é possível enviar um objeto no redirect(), a solução adotada foi
            * armazenar o retorno na sessão para ser recuperado no action do index
            */
            $this->putOnSession('return', $retorno);
            
            $model = $retorno->getData();
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            return $this->render('update', [
                'return' => $retorno,
            ]);
        }
    }

    /**
     * Deletes an existing Exemplo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $retorno = $this->getService()->delete($id);
        
        /* 
         * Como não é possível enviar um objeto no redirect(), a solução adotada foi
         * armazenar o retorno na sessão para ser recuperado no action do index
         */
        $this->putOnSession('return', $retorno);
        return $this->redirect(['index']);
    }

}
