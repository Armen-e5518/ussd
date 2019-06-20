<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GameResluts */

$this->title = 'Create Game Resluts';
$this->params['breadcrumbs'][] = ['label' => 'Game Resluts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-resluts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
