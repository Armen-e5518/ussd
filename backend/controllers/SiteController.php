<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
   /**
    * {@inheritdoc}
    */
   public function behaviors()
   {
      return [
         'access' => [
            'class' => AccessControl::className(),
            'rules' => [
               [
                  'actions' => ['login', 'error'],
                  'allow' => true,
               ],
               [
                  'actions' => ['logout', 'index'],
                  'allow' => true,
                  'roles' => ['@'],
               ],
            ],
         ],
         'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
               'logout' => ['post'],
            ],
         ],
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function actions()
   {
      return [
         'error' => [
            'class' => 'yii\web\ErrorAction',
         ],
      ];
   }

   function encrypt_decrypt($action, $string, $secret_key, $secret_iv)
   {
      $output = false;

      $encrypt_method = "AES-256-CBC";

      // hash
      $key = hash('sha256', $secret_key);

      // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
      $iv = substr(hash('sha256', $secret_iv), 0, 16);

      if ($action == 'encrypt') {
         $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
         $output = base64_encode($output);
      } else if ($action == 'decrypt') {
         $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
      }

      return $output;
   }

   /**
    * Displays homepage.
    *
    * @return string
    */
   public function actionIndex()
   {
//      return true;
//        return $this->redirect('/admin/all-attachments');
      return $this->render('index');
   }

   /**
    * Login action.
    *
    * @return string
    */
   public function actionLogin()
   {
      if (!Yii::$app->user->isGuest) {
         return $this->goHome();
      }

      $model = new LoginForm();
      if ($model->load(Yii::$app->request->post()) && $model->login()) {
         return $this->goBack();
      } else {
         $model->password = '';

         return $this->render('login', [
            'model' => $model,
         ]);
      }
   }

   /**
    * Logout action.
    *
    * @return string
    */
   public function actionLogout()
   {
      Yii::$app->user->logout();

      return $this->goHome();
   }
}
