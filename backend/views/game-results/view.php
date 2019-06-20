<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GameResluts */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Game Resluts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="game-resluts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'step',
            'return',
            'timeleft:datetime',
            'timeleft2draw:datetime',
            'timeleft2lbet:datetime',
            'party',
            'drawing_id',
            'next_drawing_id',
            'next_drawing_day_id',
            'results',
            'time:datetime',
            'duration',
            'timePassing:datetime',
            'playlistRun',
            'open',
        ],
    ]) ?>

</div>
