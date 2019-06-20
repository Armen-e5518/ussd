<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            'first_name',
            'last_name',
            'realm_id',
            'recipient',
            //'recipient',
            //'avatar',
//            'access_token',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ]
        ],
    ]); ?>
</div>
