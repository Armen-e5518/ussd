<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\AccountsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'secret_number') ?>

    <?= $form->field($model, 'pin_code') ?>

    <?= $form->field($model, 'balance') ?>

    <?= $form->field($model, 'login_token') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
