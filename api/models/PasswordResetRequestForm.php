<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\components\VSendInBlueApi;
use yii\base\Security;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;
    public $password;
    public $new_password;

    const SCENARIO_RECOVERY_PASSWORD = 'recovery_password';
    const SCENARIO_RESET_PASSWORD = 'reset_password';
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'email',
                'trim',
                'on' => self::SCENARIO_RECOVERY_PASSWORD
            ],
            [
                'email',
                'required',
                'on' => self::SCENARIO_RECOVERY_PASSWORD,
                'message' => Yii::t('api', 'Email cannot be blank.')
            ],
            [
                'email',
                'email',
                'on' => self::SCENARIO_RECOVERY_PASSWORD,
                'message' => Yii::t('api', 'Email is not a valid email address.')
            ],
            ['email', 'exist',
                'targetClass' => '\api\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Yii::t('api', 'There is no user with such email.'),
                'on' => self::SCENARIO_RECOVERY_PASSWORD
            ],
            [['password', 'new_password'], 'trim', 'on' => self::SCENARIO_RESET_PASSWORD],
            [
                ['password'],
                'required',
                'on' => self::SCENARIO_RESET_PASSWORD,
                'message' => Yii::t('api', 'Password cannot be blank.')
            ],
            [
                ['new_password'],
                'required', 'on' => self::SCENARIO_RESET_PASSWORD,
                'message' => Yii::t('api', 'New Password cannot be blank.')
            ],
            [['password'], 'validateRequestResetPassword', 'on' => self::SCENARIO_RESET_PASSWORD],
        ];
    }

    public function validateRequestResetPassword()
    {
        /* @var $User User */
        $User = Yii::$app->user->identity;
        if(!$User->validatePassword($this->password)){
            $this->addError('password', Yii::t('api', 'Following password is incorrect.'));
        }
    }

    public function updatePassword()
    {
        /* @var $User User */
        $User = Yii::$app->user->identity;
        $User->setPassword($this->new_password);
        $User->generateAccessToken();
        return $User->update(false, ['password_hash', 'access_token', 'updated_at']);
    }

    public function getAccessToken()
    {
        /* @var $User User */
        $User = Yii::$app->user->identity;
        return $User->getAccessToken();
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        $security = new Security();
        $new_password = $security->generateRandomString(6);
        $user->setScenario(User::SCENARIO_RESET_USER_PASSWORD);
        $user->setPassword($new_password);
//        $user->generateAccessToken();
        if (!$user->save()) {
            return false;
        }
//		$SendInBlueApi = new VSendInBlueApi();
//		return $SendInBlueApi->sendResetUserPasswordEmail($user, $new_password);
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                [
                    'user' => $user,
                    'new_password' => $new_password,
                ]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['supportEmailTitle']])
            ->setTo($this->email)
            ->setSubject(Yii::$app->params['subjectPasswordRecovery'])
            ->send();
    }
}