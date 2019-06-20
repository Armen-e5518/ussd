<?php
namespace common\components;

use Yii;
use yii\helpers\VarDumper;
use \yii\mail\BaseMailer;
use \common\models\AdminUser;
use \SendinBlue\Client\Api\SMTPApi;
use \SendinBlue\Client\Api\ContactsApi;
use \SendinBlue\Client\Model\SendEmail;
use \SendinBlue\Client\Model\CreateContact;
use \SendinBlue\Client\Configuration;
use \GuzzleHttp\Client;

class VSendInBlueApi extends BaseMailer
{
	/*
	 *  The constants for template id in sendinblue api.
	 */
	const ID_TEMPLATE_ADMIN_RESET_PASSWORD = 189;
	const ID_TEMPLATE_FIRST_COURSE = 169;
	const ID_TEMPLATE_BURNED_CALORIE = 197;
	const ID_TEMPLATE_PROFILE_FILLED = 170;
	const ID_TEMPLATE_PROFILE_NOT_FILLED = 170;
	const ID_TEMPLATE_USER_PASSWORD_RESET = 196;

	const ID_CONTACT_LIST = 69;

	protected function sendMessage($message)
	{

	}

	/**
	 * Request to send password reset link
	 * @param AdminUser $user
	 * @return boolean
	 */
	public function sendResetPasswordEmail(AdminUser $user)
	{
		$sent = false;
		if(YII_ENV_TEST) return true;
		$config = Configuration::getDefaultConfiguration()->setApiKey(
			'api-key', \Yii::$app->params['sendinblue_api_key']
		);
		$api_instance = new SMTPApi(
			new Client(),
			$config
		);
		$templateId = self::ID_TEMPLATE_ADMIN_RESET_PASSWORD;
		$sendEmail = new SendEmail(array(
			"emailTo" =>  array( $user->email ),
			"attributes" => array(
				'ATTRIBUTE_TOKEN' => $user->password_reset_token,
				'ATTRIBUTE_USERNAME' => $user->username,
			)
		));

		try
		{
			$result = $api_instance->sendTemplate($templateId, $sendEmail);
			if($result->valid())
			{
				$sent = true;
			}
			else
			{
				Yii::info('Exception: in sendResetPasswordEmail: ' . VarDumper::dumpAsString($result), 'send-in-blue-api');
			}
		}
		catch (\Exception $e)
		{
			Yii::info('Exception: in sendResetPasswordEmail: ' . $e->getMessage(), 'send-in-blue-api');
		}

		return $sent;
	}

	/**
	 * @param $user
	 * @return bool
	 */
	public function sendFirstCourseEmail($user)
	{
		$sent = false;
		if(YII_ENV_TEST) return true;
		$config = Configuration::getDefaultConfiguration()->setApiKey(
			'api-key', \Yii::$app->params['sendinblue_api_key']
		);
		$api_instance = new SMTPApi(
			new Client(),
			$config
		);
		$templateId = self::ID_TEMPLATE_FIRST_COURSE;
		$sendEmail = new SendEmail(array(
			"emailTo" =>  array( $user->email ),
			"attributes" => array(
				'ATTRIBUTE_FIRST_NAME' => $user->first_name,
				'ATTRIBUTE_LAST_NAME' => $user->last_name,
			)
		));

		try
		{
			$result = $api_instance->sendTemplate($templateId, $sendEmail);
			if($result->valid())
			{
				$sent = true;
			}
			else
			{
				Yii::info('Exception: in sendFirstCourseEmail: ' . VarDumper::dumpAsString($result), 'send-in-blue-api');
			}
		}
		catch (\Exception $e)
		{
			Yii::info('Exception in sendFirstCourseEmail: ' . $e->getMessage(), 'send-in-blue-api');
		}
		return $sent;
	}

	/**
	 * @param $user
	 * @return bool
	 */
	public function sendBurnedCalorieEmail($user)
	{
		$sent = false;
		if(YII_ENV_TEST) return true;
		$config = Configuration::getDefaultConfiguration()->setApiKey(
			'api-key', \Yii::$app->params['sendinblue_api_key']
		);
		$api_instance = new SMTPApi(
			new Client(),
			$config
		);
		$templateId = self::ID_TEMPLATE_BURNED_CALORIE;
		$sendEmail = new SendEmail(array(
			"emailTo" =>  array( $user->email ),
			"attributes" => array(
				'ATTRIBUTE_FIRST_NAME' => $user->first_name,
				'ATTRIBUTE_LAST_NAME' => $user->last_name,
			)
		));

		try
		{
			$result = $api_instance->sendTemplate($templateId, $sendEmail);
			if($result->valid())
			{
				$sent = true;
			}
			else
			{
				Yii::info('Exception: in sendBurnedCalorieEmail: ' . VarDumper::dumpAsString($result), 'send-in-blue-api');
			}
		}
		catch (\Exception $e)
		{
			Yii::info('Exception in sendBurnedCalorieEmail: ' . $e->getMessage(), 'send-in-blue-api');
		}
		return $sent;
	}

	/**
	 * @param $user
	 * @param $isProfileFullFilled
	 * @return bool
	 */
	public function sendProfileFilledEmail($user, $isProfileFullFilled)
	{
		$sent = false;
		if(YII_ENV_TEST) return true;
		$config = Configuration::getDefaultConfiguration()->setApiKey(
			'api-key', \Yii::$app->params['sendinblue_api_key']
		);

		$contact_api_instance = new ContactsApi(
			new Client(),
			$config
		);
		$createContact = new CreateContact(array(
			'email' => $user->email,
			'attributes' => array(
				'NOM' => $user->last_name,
				'PRENOM' => $user->first_name
			),
			'listIds' => array( self::ID_CONTACT_LIST ),
			'updateEnabled' => true,
		));

		try
		{
			$create_result = $contact_api_instance->createContact($createContact);
		}
		catch (\Exception $e)
		{
			Yii::info('Exception in sendProfileFilledEmail:createContact: ' . $e->getMessage(), 'send-in-blue-api');
		}

		$api_instance = new SMTPApi(
			new Client(),
			$config
		);
		$templateId = ($isProfileFullFilled) ? self::ID_TEMPLATE_PROFILE_FILLED : self::ID_TEMPLATE_PROFILE_NOT_FILLED;
		$sendEmail = new SendEmail(array(
			"emailTo" =>  array( $user->email ),
			"attributes" => array(
				'ATTRIBUTE_FIRST_NAME' => $user->first_name,
				'ATTRIBUTE_LAST_NAME' => $user->last_name,
			)
		));

		try
		{
			$result = $api_instance->sendTemplate($templateId, $sendEmail);
			if($result->valid())
			{
				$sent = true;
			}
			else
			{
				Yii::info('Exception: in sendProfileFilledEmail: ' . VarDumper::dumpAsString($result), 'send-in-blue-api');
			}
		}
		catch (\Exception $e)
		{
			Yii::info('Exception in sendProfileFilledEmail: ' . $e->getMessage(), 'send-in-blue-api');
		}
		return $sent;
	}

	/**
	 * @param $user
	 * @param $new_password
	 * @return bool
	 */
	public function sendResetUserPasswordEmail($user, $new_password)
	{
		$sent = false;
		if(YII_ENV_TEST) return true;
		$config = Configuration::getDefaultConfiguration()->setApiKey(
			'api-key', \Yii::$app->params['sendinblue_api_key']
		);
		$api_instance = new SMTPApi(
			new Client(),
			$config
		);
		$templateId = self::ID_TEMPLATE_USER_PASSWORD_RESET;
		$sendEmail = new SendEmail(array(
			"emailTo" =>  array( $user->email ),
			"attributes" => array(
				'ATTRIBUTE_FIRST_NAME' => $user->first_name,
				'ATTRIBUTE_LAST_NAME' => $user->last_name,
				'ATTRIBUTE_NEW_PASSWORD' => $new_password,
			)
		));

		try
		{
			$result = $api_instance->sendTemplate($templateId, $sendEmail);
			if($result->valid())
			{
				$sent = true;
			}
			else
			{
				Yii::info('Exception: in sendResetUserPasswordEmail: ' . VarDumper::dumpAsString($result), 'send-in-blue-api');
			}
		}
		catch (\Exception $e)
		{
			Yii::info('Exception in sendResetUserPasswordEmail: ' . $e->getMessage(), 'send-in-blue-api');
		}
		return $sent;
	}

}
?>
