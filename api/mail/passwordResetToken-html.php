<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <h1>Operio IMMO</h1>
    <p>Hello <?= Html::encode($user->first_name) ?> <?= Html::encode($user->last_name) ?>,</p>
    <p>Your new password:</p>
    <p><?= $new_password ?></p>
</div>
