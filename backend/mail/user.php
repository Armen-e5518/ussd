<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>

<div>
    <h3> Bonjour <?= Html::encode($user->first_name) ?> <?= Html::encode($user->last_name) ?>, </h3>
    <p>Nous sommes ravis de vous informer que vous avez désormais accès à notre application OPERIO IMMO. Vous pouvez la
        télécharger sur iOS et Android via notre site internet www.operio.immo </p>
    <p>Vous pouvez maintenant nous transmettre vos documents et utiliser tous les services proposés directement via notre application </p>
    <p>Pour vous connecter, vos identifiants de connexion sont les suivants : </p>
    <p>- Identifiant : <?= $user->email ?> </p>
    <p>- Mot de passe : <?= $user->password ?>  </p>
    <p>Il s’agit d’un mot de passe provisoire, vous serez invité à le changer lors de votre première connexion.
        Un membre de notre équipe vous contactera rapidement pour vous accompagner dans la mise en place des différents services auxquels vous avez accès. </p>
    <p>Nous restons à votre disposition pour toute question.
        N’hésitez pas à nous contacter à l’adresse suivante : <a href="mailto:operioimmo@fr.gt.com">operioimmo@fr.gt.com </a>
    </p>
    <p>Toute l’équipe Operio Immo vous souhaite la bienvenue ! </p>
</div>
