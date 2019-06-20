<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Participation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participation-form">

   <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'grille')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'coeff')->textInput() ?>

   <?= $form->field($model, 'uniteBase')->textInput() ?>

   <?= $form->field($model, 'flash')->textInput() ?>

   <?= $form->field($model, 'numParty')->textInput() ?>

   <?= $form->field($model, 'idRemote')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'date')->textInput() ?>

   <?= $form->field($model, 'numCollector')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'status')->textInput() ?>

   <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'idHost')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'dateSession')->textInput() ?>

   <?= $form->field($model, 'session')->textInput() ?>

   <?= $form->field($model, 'bet_amount')->textInput() ?>

   <?= $form->field($model, 'party')->textInput() ?>

   <?= $form->field($model, 'nature')->textInput(['maxlength' => true]) ?>

   <div class="form-group">
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>

</div>
