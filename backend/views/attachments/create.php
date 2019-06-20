<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Attachments */

$this->title = 'Create attachment';
$this->params['breadcrumbs'][] = ['label' => 'Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachments-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
