<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
 * @property string $password_hash_update
 * @property string $realm_id
 * @property string $role
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $_avatar;
    public $password_hash_update;

    const ROLE_CLIENT = 1;
    const ROLE_MANAGER = 2;
    public $password;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['_avatar'], 'file', 'extensions' => 'png, jpg'],
            [['auth_key', 'password_hash', 'email', 'first_name', 'last_name', 'access_token'], 'required'],
            [['status', 'created_at', 'updated_at', 'role'], 'integer'],
            [['password_hash', 'password_reset_token', 'email', 'first_name', 'last_name', 'recipient', 'avatar', 'access_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash_update'], 'string', 'max' => 20],
            [['username'], 'unique'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['realm_id'], 'unique'],
            [['realm_id'], 'integer'],
            [['realm_id'], 'string', 'max' =>15],
            [['realm_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'recipient' => 'Tel. number',
            'avatar' => 'Avatar',
            '_avatar' => 'Avatar',
            'access_token' => 'Access Token',
            'password_hash_update' => 'Update password',
            'realm_id' => 'Realm id',
        ];
    }

    public function upload()
    {
        if (!empty($this->_avatar)) {
            $img_name = microtime(true) . '.' . $this->_avatar->extension;
            if ($this->_avatar->saveAs('../../frontend/web/users/' . $img_name)) {
                return $img_name;
            }
        }
        return false;
    }

    public function SaveClient()
    {
        $this->password = $this->password_hash;
        $this->password_hash = !$this->password_hash ? $this->password_hash : Yii::$app->security->generatePasswordHash($this->password_hash);
        $this->password_hash = $this->password_hash_update ? Yii::$app->security->generatePasswordHash($this->password_hash_update) : $this->password_hash;
        $this->auth_key = $this->auth_key ? $this->auth_key : Yii::$app->security->generateRandomString();
        $this->access_token = $this->access_token ? $this->access_token : md5(microtime(true));
        $this->username = $this->username ? $this->username : md5(microtime(true));
        $this->role = self::ROLE_CLIENT;
        return $this->save();
    }

    public function SaveManager()
    {
        $this->password_hash = !$this->password_hash ? $this->password_hash : Yii::$app->security->generatePasswordHash($this->password_hash);
        $this->password_hash = $this->password_hash_update ? Yii::$app->security->generatePasswordHash($this->password_hash_update) : $this->password_hash;
        $this->auth_key = $this->auth_key ? $this->auth_key : Yii::$app->security->generateRandomString();
        $this->access_token = $this->access_token ? $this->access_token : md5(microtime(true));
        $this->username = $this->username ? $this->username : $this->email;
        $this->realm_id = microtime(true);
        $this->role = self::ROLE_MANAGER;
        return $this->save();
    }

    public static function GetUserById($id)
    {
        return self::find()->select(["CONCAT(`first_name`,' ',`last_name`) as name"])->asArray()->where(['id' => $id])->one()['name'];
    }

    public static function GetAllUsersIndex()
    {
        return self::find()->select(["CONCAT(`first_name`,' ',`last_name`) as name", 'id'])->indexBy('id')->column();
    }

    public static function GetRealmIdCurrentUser()
    {
        return self::findOne(Yii::$app->user->getId())['realm_id'];
    }

    public static function GetRealmIdByUserId($id)
    {
        return self::findOne($id)['realm_id'];
    }

    public static function GetClients()
    {
        return self::find()
            ->select(["CONCAT(`first_name`,' ',`last_name`) as name", 'id'])
            ->where(['role' => self::ROLE_CLIENT])
            ->indexBy('id')
            ->column();
    }
}
