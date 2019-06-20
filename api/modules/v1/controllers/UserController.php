<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\base\Event;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\data\ActiveDataProvider;

use api\models\PasswordResetRequestForm;
use api\models\FbUser;
use api\models\FbLoginForm;
use api\models\LoginForm;
use api\models\UserSearch;
use api\models\User;
use api\components\VActiveController;
use yii\web\UploadedFile;


class UserController extends VActiveController
{

    public $modelClass = 'api\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();
        // disable the "delete", "create", "update", "view" and "options" actions
        unset($actions['delete'], $actions['create'], $actions['update'], $actions['view'], $actions['options']);

        return $actions;
    }

    /**
     * Login User
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin()
    {
        $success = true;
        $errors = [];
        $access_token = null;
        $login_status = 0;
        $model = new LoginForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->login()) {
            $User = $model->getUser();
            $access_token = $User->access_token;
            $login_status = $User->login_status;
        } else {
            $errors = $model->getErrors();
            $success = false;
        }
        return [
            'success' => $success,
            'errors' => $errors,
            'access_token' => $access_token,
            'login_status' => $login_status,
        ];
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        $success = false;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                $success = true;
            }
        }
        return [
            'success' => $success,
            'errors' => $model->getErrors(),
        ];
    }


    /**
     * Login with Facebook
     * To process login will have following scenario
     * Case when fb_id in user table exists return access token and exit
     * Case when fb_id in user table does not exists
     *          * if email exists then update fb_id and return access token and exit
     *          * if email does not exists then call to Facebook by fb token to retrieve data.
     *              * create new User account return access token and exit.
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAuthWithFacebook()
    {
        $success = false;
        $errors = [];
        $access_token = null;
        $sender = null;
        $FbLoginForm = new FbLoginForm();
        $FbLoginForm->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($FbLoginForm->validate()) {
            if ($FbLoginForm->hasUserAccountAccess()) {
                $success = true;
                $sender = $User = $FbLoginForm->getUser();
                $access_token = $User->getAccessToken();
            } else if ($FbLoginForm->callToFacebook()) {
                $FbUser = $FbLoginForm->getFbUser();
                $User = new FbUser($FbUser);
                if ($User->validate()) {
                    if ($User->createUserAccount()) {
                        $sender = $newUser = $User->getUser();
                        $success = true;
                        $access_token = $newUser->getAccessToken();
                    } else {
                        $newUser = $User->getUser();
                        $errors = $newUser->getErrors();
                    }
                } else {
                    $errors = $User->getErrors();
                }
            } else {
                $errors = $FbLoginForm->getErrors();
            }
        } else {
            $errors = $FbLoginForm->getErrors();
        }

        if ($success) {
            $BadgeSystem = new BadgeSystem();
            $BadgeSystem->trigger(BadgeSystem::EVENT_FACEBOOK_LOGIN, new Event(['sender' => $sender]));
        }

        return [
            'success' => $success,
            'errors' => $errors,
            'access_token' => $access_token,
        ];
    }

    /**
     * Create new User
     * @return Response
     */
    public function actionCreateUser()
    {
        $success = false;
        $errors = [];
        $access_token = null;
        /* @var $model User */
        $model = new $this->modelClass([
            'scenario' => User::SCENARIO_CREATE_USER
        ]);

        $model->load(Yii::$app->request->post(), '');
        $model->convertDateFormat();
        if ($model->validate()) {
            $model->setPassword($model->api_password);
            $model->generateAccessToken();
            if ($model->save()) {
                $success = true;
                $access_token = $model->access_token;
            } else {
                $errors = $model->getErrors();
            }
        } else {
            $errors = $model->getErrors();
        }

        return [
            'success' => $success,
            'errors' => $errors,
            'access_token' => $access_token,
        ];
    }

    /**
     * Updating User preview
     * @return array
     * @throws ServerErrorHttpException
     */
    public function actionUpdateUserPreview()
    {
        $success = false;
        $errors = [];
        /* @var $model User */
        $model = Yii::$app->user->identity;
        $model->setScenario(User::SCENARIO_UPDATE_USER_PREVIEW);
        $model->load(Yii::$app->request->post(), '');
        $isValid = $model->validate();
        if (!$isValid) $errors[] = $model->getErrors();
        // missions
        $UserMission = new UserMission;
        $userMission = $UserMission->loadMissionData(Yii::$app->request->post('mission_ids', array()));
        if (empty($userMission)) $errors[] = $UserMission->getErrors();
        // bikes
        $UserBike = new UserBike;
        $userBike = $UserBike->loadBikeData(Yii::$app->request->post('bike_ids', array()));
        if (empty($userBike)) $errors[] = $UserBike->getErrors();
        $isValid = $isValid && !empty($userMission) && !empty($userBike);
        if ($isValid) {
            $success = $model->processToUpdatePreview($userMission, $userBike);
        }
        if ($success) {
            // send profile email notification
            $EmailNotification = new EmailNotification();
            $EmailNotification->setUser($model);
            $EmailNotification->trigger(EmailNotification::EVENT_PROFILE_FILLED);
        }

        return [
            'success' => $success,
            'errors' => $errors,
        ];
    }

    /**
     * Updating User
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdateUser()
    {
        /* @var $model User */
        $model = Yii::$app->user->identity;
        $errors = [];
        $success = false;
        $model->setScenario(User::SCENARIO_UPDATE_USER);
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if (!empty($model->old_password) && $model->validateOldPassword()) {
            $model->updatePassword();
        } elseif (!empty($model->old_password)) {
            $errors['message'] = 'Password is incorrect';
            return [
                'success' => $success,
                'errors' => $errors
            ];
        }
        if (\Yii::$app->request->isPost) {
            $model->_avatar = UploadedFile::getInstanceByName('_avatar');
            $name = $model->upload();
            if (!empty($name)) {
                $model->avatar = (string)$name;
                $model->_avatar = null;
            }
        }
        $model->login_status = 1;
        if ($model->save()) {
            $success = true;
//                if ($model->canDeleteAvatar()) {
//                    $model->deleteAvatar();
//                }
        } else {
            $success = false;
            $errors = $model->getErrors();
        }

        return [
            'res' => 'OK',
            'success' => $success,
            'errors' => $errors,
        ];
    }

    /**
     * Search user list to add friend
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSearchFriend()
    {
        $searchModel = new UserSearch;
        return array_merge(
            ['success' => true],
            Yii::createObject($this->serializer)
                ->serialize(
                    $searchModel->searchFriend(\Yii::$app->request->queryParams)
                )
        );
    }

    /**
     * Requests recovery password.
     * @return array
     */
    public function actionRequestRecoveryPassword()
    {
        $success = true;
        $errors = [];
        $model = new PasswordResetRequestForm(['scenario' => PasswordResetRequestForm::SCENARIO_RECOVERY_PASSWORD]);
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            if (!$model->sendEmail()) {
                $success = false;
                $errors = $model->getErrors();
            }
        } else {
            $success = false;
            $model->validate();
            $errors = $model->getErrors();
        }
        return [
            'success' => $success,
            'errors' => $errors,
        ];
    }

    /**
     * Requests reset password.
     * Uses in app edit profile page.
     * @return array
     */
    public function actionRequestResetPassword()
    {
        $success = true;
        $errors = [];
        $access_token = null;
        $model = new PasswordResetRequestForm(['scenario' => PasswordResetRequestForm::SCENARIO_RESET_PASSWORD]);
        if ($model->load(Yii::$app->request->post(), '') && $model->validate() && $model->updatePassword()) {
            $access_token = $model->getAccessToken();
        } else {
            $success = false;
            $model->validate();
            $errors = $model->getErrors();
        }
        return [
            'success' => $success,
            'errors' => $errors,
            'access_token' => $access_token,
        ];
    }

    /**
     * Get current User information
     * @return array
     */
    public function actionGetUser()
    {
        $success = true;
        $id = Yii::$app->user->identity->getId();
        $User = User::find()->where(['id' => $id])->one();
        if ($User == null) $success = false;
        return [
            'success' => $success,
            'User' => $User
        ];
    }

    /**
     * Show particular user profile
     * @param $id
     * @return array
     */
    public function actionShowUserProfile($id)
    {
        $success = true;
        $User = User::find()->where(['id' => $id])->active()->one();
        if ($User == null) $success = false;
        return [
            'success' => $success,
            'User' => $User
        ];
    }

    /**
     * This action uses to sync MySocialApp users to add.
     * Action is temporary and will be remove after sync process will be made.
     * @package SOCIAL_APP
     * @return array
     */
    public function actionGetAllUsers()
    {
        $hash = (isset($_GET['hash']) && $_GET['hash'] == 'de79b40d62c6b405ae6a1097e6311ace8f2bcc33') ?: null;
        if (!isset($hash)) exit;
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $query = User::find()->with(['userFriends'])->where(['status' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return array_merge(
            [
                'success' => true,
            ],
            Yii::createObject($this->serializer)->serialize($dataProvider)
        );
    }

    /**
     * This action uses to sync MySocialApp requested friends to accept.
     * Action is temporary and will be remove after sync process will be made.
     * @package SOCIAL_APP
     * @return array
     */
    public function actionGetIncomingUsers()
    {
        $hash = (isset($_GET['hash']) && $_GET['hash'] == 'de79b40d62c6b405ae6a1097e6311ace8f2bcc33') ?: null;
        if (!isset($hash)) exit;
        $subQuery = UserFriend::find()->select('friend_id')->where(['status' => 1]);
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $query = User::find()->where(['in', 'id', $subQuery])->active();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return array_merge(
            [
                'success' => true,
            ],
            Yii::createObject($this->serializer)->serialize($dataProvider)
        );
    }
}