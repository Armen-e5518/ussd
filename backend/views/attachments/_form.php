<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Attachments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attachments-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($model->image)): ?>
                <div class="field-user-imagefile attachment gray-bg padding-5 margin-btn-5">
                    <div class="attachment-img">
                        <img width="25%" src="/attachments/<?= $model->image ?>" alt="">
                    </div>
                </div>
            <?php endif; ?>
            <?= $form->field($model, '_image')->fileInput(); ?>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'status')->dropDownList(['Compte pro', 'Autres']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
