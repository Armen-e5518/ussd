<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ParticipationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'grille') ?>

    <?= $form->field($model, 'coeff') ?>

    <?= $form->field($model, 'uniteBase') ?>

    <?= $form->field($model, 'flash') ?>

    <?php // echo $form->field($model, 'numParty') ?>

    <?php // echo $form->field($model, 'idRemote') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'numCollector') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'idHost') ?>

    <?php // echo $form->field($model, 'dateSession') ?>

    <?php // echo $form->field($model, 'session') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'party') ?>

    <?php // echo $form->field($model, 'nature') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
