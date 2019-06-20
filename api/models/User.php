<?php

namespace api\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;
use yii\db\Query;
use common\models\User as CommonUser;
use common\behaviors\VFileUploadBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property string $recipient
 * @property string $avatar
 * @property string $access_token
 * @property string $_avatar
 * @property string $login_status
 *
 * Properties accessing via relations
 * @property integer $badgeInfo
 */
class User extends CommonUser
{
    const IS_DELETE_PHOTO = 0;
    const IS_NOT_DELETE_PHOTO = 1;

    const LOGIN_STATUS_NEW = 0;
    const LOGIN_STATUS_CHANGE = 1;

    /**
     * @var UploadedFile
     */
    public $_avatar;
    /**
     * @var $login_status
     */
//    public $login_status;
    /**
     * @var $old_password
     */
    public $old_password;
    /**
     * @var $api_password
     */
    public $api_password;

    /**
     * @var $api_confirm_password
     */
    public $api_confirm_password;

    /**
     * Possible values 0 OR 1
     * If set 1 then User avatar must be delete.
     * Property is optional
     * @var $is_delete_photo
     */
    public $is_delete_photo;

    public $related_user_ids;

    public static $find_scenario;

    /**
     * Possible values 0 OR 1
     * Checking User password is empty or not
     * Uses in following scenario
     * Scenario:
     * User logged from facebook and does not have password in this case app edit profile page not display password reset button.
     * User may logged out then recovery password. In this case User will have password
     * Application would like to know user have password or not (display reset button or not).
     *
     * Property is optional
     * @var $is_internal boolean
     */
    public $is_internal;

    /**
     * Scenario constants
     */
    const SCENARIO_SEARCH_FRIEND = 'search_friend';
    const SCENARIO_FIND_USER = 'find_user';
    const SCENARIO_CREATE_USER = 'create_user';
    const SCENARIO_CREATE_USER_FROM_FB = 'create_user_from_facebook';
    const SCENARIO_UPDATE_USER_PREVIEW = 'update_user_preview';
    const SCENARIO_UPDATE_USER = 'update_user';
    const SCENARIO_RESET_USER_PASSWORD = 'reset_user_password';

    const UPLOAD_DIR = 'user';
    const DISALLOW_PREVIEW_PAGE_STATUS = 1;

    public function afterFind()
    {
        self::populateFindScenarios();
        parent::afterFind();
    }

    public function populateFindScenarios()
    {
        if (self::$find_scenario !== null) {
            self::setScenario(self::$find_scenario);
            return true;
        }
        return false;
    }

    public static function setFindScenario($scenario)
    {
        self::$find_scenario = $scenario;
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }


    /**
     * @package SOCIAL_APP
     */
    public function extraFields()
    {
        return ['userFriendsTemp'];
    }


    public function getProfileFields()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => $this->populateAvatar()
        ];
    }

    public function upload()
    {
        if (!empty($this->_avatar)) {
            $img_name = md5(microtime(true)) . '.' . $this->_avatar->extension;
            if ($this->_avatar->saveAs(Yii::getAlias('@frontend') . '/web/users/' . $img_name)) {
                return $img_name;
            }
        }
        return false;
    }


    /**
     * @return mixed
     */
    private function populateAvatar()
    {
        return $this->getUploadUrl('avatar');
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE_USER => [
                'email',
                'first_name',
                'last_name',
                'api_password',
                'api_confirm_password',
            ],
            self::SCENARIO_CREATE_USER_FROM_FB => [
                'email', 'first_name', 'last_name', 'gender', 'fb_id', 'avatar'
            ],
            self::SCENARIO_UPDATE_USER => [
                'email',
                'first_name',
                'last_name',
                'avatar',
                'old_password',
                'api_password',
                'recipient',
                'login_status',
            ],
            self::SCENARIO_RESET_USER_PASSWORD => [
                'password_hash',
                'access_token',
            ],
        ];
    }
//
//    /**
//     * @inheritdoc
//     */
//    function behaviors()
//    {
//        return ArrayHelper::merge(
//            parent::behaviors(), [
//            [
//                'class' => VFileUploadBehavior::className(),
//                'attribute' => 'img',
//                'scenarios' => [self::SCENARIO_UPDATE_USER],
//                'path' => '@upload/' . self::UPLOAD_DIR,
//                'url' => '@uploadUrl/' . self::UPLOAD_DIR,
//                'instanceByName' => true,
//            ],
//        ]);
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['first_name'],
                'required',
                'message' => Yii::t('api', 'First Name cannot be blank.')
            ], [
                ['login_status'],
                'required',
                'message' => Yii::t('api', 'login_status cannot be blank.')
            ],
            [
                ['last_name'],
                'required',
                'message' => Yii::t('api', 'Last Name cannot be blank.')
            ],
            [
                ['api_confirm_password'],
                'required',
                'message' => Yii::t('api', 'Confirm Password cannot be blank.')
            ],
            [
                ['first_name', 'last_name'],
                'string',
                'max' => 50,
                'tooLong' => Yii::t('api', 'Attribute must be no greater than {max}.')
            ],
            [
                ['email', 'password_hash', 'recipient'],
                'string',
                'max' => 255,
                'tooLong' => Yii::t('api', 'Attribute must be no greater than {max}.')
            ],
            [
                ['email'],
                'required',
                'on' => [self::SCENARIO_CREATE_USER, self::SCENARIO_UPDATE_USER],
                'message' => Yii::t('api', 'Email cannot be blank.')
            ],
            [
                ['email'],
                'unique',
                'message' => Yii::t('api', 'Attribute has already been taken.')
            ],
            [
                'email',
                'email',
                'message' => Yii::t('api', 'Email is not a valid email address.')
            ],
            // rules for actionUpdateUser()
            [
                ['avatar'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'jpg, gif, png',
                'wrongExtension' => Yii::t('api', 'Only files with these extensions are allowed: jpg, gif, png.'),
                'tooBig' => Yii::t('api', 'The file is too big.')
            ],
            [
                ['is_delete_photo'],
                'in',
                'range' => [self::IS_DELETE_PHOTO, self::IS_NOT_DELETE_PHOTO],
                'on' => [self::SCENARIO_UPDATE_USER],
                'message' => Yii::t('api', 'Incorrect attribute value.')
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'avatar' => 'Avatar',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'recipient' => 'recipient',
            'login_status' => 'login_status',
        ];
    }


    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::find()
            ->select(['id',
                'password_hash',
                'login_status',
                'access_token'
            ])
            ->where(['email' => $email, 'status' => self::STATUS_ACTIVE])
            ->one();
    }


    public function updateFacebookId($fb_id)
    {
        $this->setAttribute('fb_id', $fb_id);
        return $this->update(false, ['fb_id', 'updated_at']);
    }

    /**
     * Get User by Id
     * @param $id
     * @return bool
     */
    public static function isUser($id)
    {
        return self::find()
            ->where(['id' => $id])
            ->active()
            ->exists();
    }

    /**
     * Checking whether avatar must deleted or not
     * @property $is_delete_photo must set as 1 from application
     * In this case we could remove avatar photo.
     * @return bool
     */
    public function canDeleteAvatar()
    {
        return isset($this->is_delete_photo) && $this->is_delete_photo;
    }

    /**
     * Deleting avatar
     * @return bool|false|int
     * @throws \Exception
     */
    public function deleteAvatar()
    {
        $self = self::findOne($this->id);
        if ($self !== null) {
            $self->avatar = null;
            return $self->update(false, ['avatar']);
        }

        return false;
    }


    /**
     * @return bool
     */
    public function isProfileFullFilled()
    {
        $attributes = $this->getAttributes([
            'first_name',
            'last_name',
            'email',
        ]);
        $is_profile_full_filled = true;
        foreach ($attributes as $key => $value) {
            if (!isset($value) || trim($value) === '') {
                $is_profile_full_filled = false;
            }
        }
        return $is_profile_full_filled;
    }

    public function validateOldPassword()
    {
        return Yii::$app->security->validatePassword($this->old_password, $this->password_hash);
    }

    public function updatePassword()
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($this->api_password);
    }
}