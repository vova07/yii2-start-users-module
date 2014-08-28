<?php

/**
 * Activation email view.
 *
 * @var \yii\web\View $this View
 * @var \vova07\users\models\frontend\User $model Model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::toRoute(['/users/guest/activation', 'token' => $model['token']], true); ?>
<p>Здравствуйте <?= Html::encode($model['username']) ?>!</p>
<p>Перейдите по ссылке ниже чтобы подтвердить свой электронный адрес и активировать свой аккаунт:</p>
<p><?= Html::a(Html::encode($url), $url) ?></p>