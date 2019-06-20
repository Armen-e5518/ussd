<?php

namespace backend\controllers;

use common\models\GameResults;
use common\models\search\GameResultsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GameResultsController implements the CRUD actions for GameResults model.
 */
class GameResultsController extends Controller
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
    * Lists all GameResults models.
    * @return mixed
    */
   public function actionIndex()
   {
//      GameResults::CroneJobFor();
      $searchModel = new GameResultsSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   public function actionCroneJobXyz()
   {
      GameResults::CroneJob();
   }

   /**
    * Displays a single GameResults model.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionView($id)
   {
      return $this->render('view', [
         'model' => $this->findModel($id),
      ]);
   }

   /**
    * Creates a new GameResults model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
   public function actionCreate()
   {
      $model = new GameResults();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('create', [
         'model' => $model,
      ]);
   }

   /**
    * Updates an existing GameResults model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionUpdate($id)
   {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('update', [
         'model' => $model,
      ]);
   }

   /**
    * Deletes an existing GameResults model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionDelete($id)
   {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
   }

   /**
    * Finds the GameResults model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return GameResults the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = GameResults::findOne($id)) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }
}

