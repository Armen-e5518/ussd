<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ParticipationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participation-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'account_id',
            'grille',
            'coeff',
            'uniteBase',
            'flash',
            'numParty',
            //'idRemote',
            //'date',
            //'numCollector',
            //'status',
            //'state',
            //'idHost',
            //'dateSession',
            //'session',
            'bet_amount',
            'drawing_id',
            //'party',
            //'nature',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
