<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Participation */

$this->title = 'Update Participation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Participations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="participation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
