<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GameResluts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-resluts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'step')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'return')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timeleft')->textInput() ?>

    <?= $form->field($model, 'timeleft2draw')->textInput() ?>

    <?= $form->field($model, 'timeleft2lbet')->textInput() ?>

    <?= $form->field($model, 'party')->textInput() ?>

    <?= $form->field($model, 'drawing_id')->textInput() ?>

    <?= $form->field($model, 'next_drawing_id')->textInput() ?>

    <?= $form->field($model, 'next_drawing_day_id')->textInput() ?>

    <?= $form->field($model, 'results')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'timePassing')->textInput() ?>

    <?= $form->field($model, 'playlistRun')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'open')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
