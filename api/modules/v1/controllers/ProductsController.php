<?php

namespace api\modules\v1\controllers;


use api\modules\v1\models\Products;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;



/**
 * Class ProductsController
 * @package api\modules\v1\controllers
 */
class ProductsController extends ActiveController
{

    public $modelClass = 'api\modules\v1\models\Products';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            //'class' => HttpBasicAuth::className(),
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        return $behaviors;
    }

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
    public function actionGetConfig()
    {
        return \Yii::$app->params;
    }
}