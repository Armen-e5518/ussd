<?php

namespace api\components;

use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use api\models\User;

/**
 * Extend Active Controller.  All controllers for the API should extend from here.
 */
class VActiveController extends ActiveController
{

    public $modelClass = 'api\models\User';

    public function beforeAction($event)
    {
		if(isset($_GET['debug'])){
			\Yii::$app->user->identity = User::findOne(1); // 2381 is a id of test user to see output in browser and must remove later
		}
        return parent::beforeAction($event);
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
		if(!isset($_GET['debug'])){
			$behaviors['authenticator'] = [
				'class' => VHttpBearerAuth::className(),
				'except' => [
					'login',
					'create-user',
					'request-recovery-password',
					'auth-with-facebook',
					'get-static-content', // uses in MetaController
					'get-all-users', /** @package SOCIAL_APP */
					'get-incoming-users', /** @package SOCIAL_APP */
					'get-requested-friend-list', /** @package SOCIAL_APP */
				],
			];
		}

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

	/**
	 * @return User
	 */
	protected function getUser()
	{
		/* @var $User User */
		$User = \Yii::$app->user->identity;
		return $User;
	}
}