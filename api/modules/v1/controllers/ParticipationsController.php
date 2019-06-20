<?php

namespace api\modules\v1\controllers;


use api\components\AddPart;
use api\components\VActiveController;
use common\components\Api;
use common\models\Participation;


/**
 * Class ProductsController
 * @package api\modules\v1\controllers
 */
class ParticipationsController extends VActiveController
{

   public $modelClass = 'beckend\modules\Participation';


   public function actions()
   {
      $actions = parent::actions();
      // disable the "delete", "create", "update", "view" and "options" actions
      unset($actions['delete'], $actions['create'], $actions['update'], $actions['view'], $actions['options']);
      return $actions;
   }

   /**
    * @return array|null
    */
   public function actionAaa()
   {
      return [
         'res' => 1
      ];
   }

   /**
    * @return array
    */
   public function actionAddNew()
   {
      $model = new Participation();

      if (\Yii::$app->request->post() && $model->load(\Yii::$app->request->post(), '')) {
         AddPart::NewPart($model);

         if ($model->save()) {
            return [
               'return' => 'ok',
               'timestamp' => strtotime("now"),
               'result' => $model,
               'result_time' => $model->timer,
               'step' => $model->step,
               'error' => 0,
               'message' => ''
            ];
         }
         return [
            'return' => 'nok',
            'timestamp' => strtotime("now"),
            'result' => [],
            'error' => 1,
            'message' => $model->getErrors()
         ];
      }
      return [
         'error' => 'M_ERR_1 :'
      ];
   }

///getStatut?id=&amp;where=
   public function actionGetStatus()
   {
      $get = \Yii::$app->request->get();
      if ($get && (!empty($get['where']) || !empty($get['where']) == 'remote')) {
         Participation::UpdateBet($get['id'], $get['where']);
         if ($get['where'] == 'host') {
            $date = Participation::findOne(['idHost' => $get['id']]);
         }
         if ($get['where'] == 'remote') {
            $date = Participation::findOne(['idRemote' => $get['id']]);
         }
         return [
            'return' => 'ok',
            'timestamp' => strtotime("now"),
            'result' => $date,
            'error' => 0,
            'message' => ''
         ];
      }
      return [
         'error' => 'M_ERR_1 :'
      ];
   }

//getResult?numSession=&amp;numParty=&amp;nbParty=
   public function actionGetResults()
   {
      $get = \Yii::$app->request->get();
      if ($get) {
         $date = Participation::GetResultsByDaySession($get);
         return [
            'return' => 'ok',
            'timestamp' => strtotime("now"),
            'result' => $date,
            'error' => 0,
            'message' => ''
         ];
      }
      return [
         'error' => 'M_ERR_1 :'
      ];
   }

   public function actionCancel()
   {
      $post = \Yii::$app->request->post();
      if ($post && (!empty($post['where']) || !empty($post['where']) == 'remote')) {
         return [
            'return' => 'ok',
            'timestamp' => strtotime("now"),
            'result' => Participation::Cancel($post['id'], $post['where']),
            'error' => 0,
            'message' => ''
         ];
      }
      return [
         'error' => 'M_ERR_1 :'
      ];
   }

   public function actionGetResultsByPartyAndDate()
   {
      $get = \Yii::$app->request->get();
      if ($get) {
         $date = Participation::GetResultsByPartyAndDate($get);
         return [
            'return' => 'ok',
            'timestamp' => strtotime("now"),
            'result' => $date,
            'error' => 0,
            'message' => ''
         ];
      }
      return [
         'error' => 'M_ERR_1 :'
      ];
   }

   public function actionGetCurrentGameResult()
   {
      return [
         'return' => 'ok',
         'timestamp' => strtotime("now"),
         'result' => Api::getGameState(),
         'error' => 0,
         'message' => ''
      ];
   }

   public function actionGetResultsByStatus()
   {
      $get = \Yii::$app->request->get();
      if ($get) {
         $date = Participation::GetResultsByStatus($get);
         return [
            'return' => 'ok',
            'timestamp' => strtotime("now"),
            'result' => $date,
            'error' => 0,
            'message' => ''
         ];
      }
      return [
         'error' => 'M_ERR_1 :'
      ];
   }
}

