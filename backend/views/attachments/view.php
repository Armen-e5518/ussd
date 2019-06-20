<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Attachments */

$this->title = $model->comment;
$this->params['breadcrumbs'][] = ['label' => 'Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachments-view">
    <div>
        <img width="50%" src="/attachments/<?=$model->image?>" alt="">
    </div>
</div>
