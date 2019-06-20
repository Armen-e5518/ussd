<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('//code.jquery.com/jquery-3.3.1.min.js');
$this->registerJsFile('/admin/js/user.js');

?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'realm_id')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'recipient')->textInput(['maxlength' => true]) ?>
            <div class="form-group field-user-email required">
                <label><input type="checkbox" id="user-pass">Change password</label>
            </div>
            <?= $form->field($model, 'password_hash_update')->passwordInput(['required' => true, 'disabled' => 'disabled']) ?>
            <?php if (!empty($model->avatar)): ?>
                <div class="field-user-imagefile attachment gray-bg padding-5 margin-btn-5">
                    <div class="attachment-img">
                        <img width="25%" src="/users/<?= $model->avatar ?>" alt="">
                    </div>
                </div>
            <?php endif; ?>
            <?= $form->field($model, '_avatar')->fileInput(); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
