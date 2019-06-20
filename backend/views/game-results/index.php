<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GameReslutsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Game Resluts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-resluts-index">


   <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
         ['class' => 'yii\grid\SerialColumn'],

//            'id',
         'step',
         'return',
//            'timeleft:datetime',
//            'timeleft2draw:datetime',
         //'timeleft2lbet:datetime',
         //'party',

         //'next_drawing_id',
         //'next_drawing_day_id',
         'results',
         //'time:datetime',
         //'duration',
         //'timePassing:datetime',
         //'playlistRun',
         //'open',
         'drawing_id',
//         ['class' => 'yii\grid\ActionColumn'],
      ],
   ]); ?>
</div>
