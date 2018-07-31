<?php

namespace app\controllers;

use Yii;
use app\models\FeriadoRecord;
use app\enums\MesEnum;
use app\models\service\FeriadoService;
use app\models\search\FeriadoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeriadoController implements the CRUD actions for FeriadoRecord model.
 */
class FeriadoController extends ControllerTrait
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
     * @return FeriadoService
     */
    private function getService(){
        return new FeriadoService();
    }

    /**
     * Lists all FeriadoRecord models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeriadoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeriadoRecord model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $retorno = $this->getService()->findById($id);

        return $this->render('view', [
            'model' => $retorno->getData(),
        ]);
    }

    /**
     * Creates a new FeriadoRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $mesList = MesEnum::getValues();
        $retorno = $this->getService()->persist();

        if($retorno->getSuccess()){
            $model = $retorno->getData();
            
            $this->addFlashMessage($retorno);

            return $this->redirect([
                'view',
                'id' => $model->id,
                'mesList' => $mesList
            ]);
        }else{
            $this->addFlashMessage($retorno);

            return $this->render('create', [
                'model' => $retorno->getData(),
                'mesList' => $mesList
            ]);
        }
    }

    /**
     * Updates an existing FeriadoRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $mesList = MesEnum::getValues();
        $retorno = $this->getService()->persist($id);
        if($retorno->getSuccess()){
            $model = $retorno->getData();

            $this->addFlashMessage($retorno);
            
            return $this->redirect([
                'view',
                'id' => $model->id,
                'mesList' => $mesList
            ]);
        }else{
            $this->addFlashMessage($retorno);

            return $this->render('update', [
                'model' => $retorno->getData(),
                'mesList' => $mesList
            ]);
        }
    }

    /**
     * Deletes an existing FeriadoRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $retorno = $this->getService()->delete($id);

        $this->addFlashMessage($retorno);
        
        return $this->redirect(['index']);
    }
    
}
