<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\GameReslutsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-resluts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'step') ?>

    <?= $form->field($model, 'return') ?>

    <?= $form->field($model, 'timeleft') ?>

    <?= $form->field($model, 'timeleft2draw') ?>

    <?php // echo $form->field($model, 'timeleft2lbet') ?>

    <?php // echo $form->field($model, 'party') ?>

    <?php // echo $form->field($model, 'drawing_id') ?>

    <?php // echo $form->field($model, 'next_drawing_id') ?>

    <?php // echo $form->field($model, 'next_drawing_day_id') ?>

    <?php // echo $form->field($model, 'results') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'timePassing') ?>

    <?php // echo $form->field($model, 'playlistRun') ?>

    <?php // echo $form->field($model, 'open') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
