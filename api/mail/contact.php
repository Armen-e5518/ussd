<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div>
    <h1>Operio IMMO</h1>
    <p>Message:
        <em>
            <?= $model->message ?>
        </em>
    </p>
    <p>Besoin d’être rappelé ? <?= $model->status ? 'Yes' : 'No' ?></p>
</div>
