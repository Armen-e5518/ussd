<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "accounts".
 *
 * @property int $id
 * @property int $secret_number
 * @property string $pin_code
 * @property double $balance
 * @property string $login_token
 * @property string $create_at
 */
class Accounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['secret_number'], 'integer'],
            [['balance'], 'number'],
            [['pin_code', 'login_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'secret_number' => 'Secret Number',
            'pin_code' => 'Pin Code',
            'balance' => 'Balance',
            'login_token' => 'Login token',
            'create_at' => 'Create At',
        ];
    }
}
