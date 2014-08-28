<?php

/**
 * Email change email view.
 *
 * @var \yii\web\View $this View
 * @var \vova07\users\models\frontend\Email $model Model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::toRoute(['/users/guest/email', 'token' => $model['token']], true); ?>
<p>Здравствуйте!</p>
<p>Перейдите по ссылке ниже чтобы подтвердить новый электронный адрес:</p>
<p><?= Html::a(Html::encode($url), $url) ?></p>