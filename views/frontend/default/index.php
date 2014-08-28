<?php

/**
 * User list page view.
 *
 * @var yii\web\View $this View
 * @var yii\data\ActiveDataProvider $dataProvider DataProvider
 */

use vova07\users\Module;
use yii\widgets\ListView;

$this->title = Module::t('users', 'FRONTEND_INDEX_TITLE');
$this->params['subtitle'] = Module::t('users', 'FRONTEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    $this->title
]; ?>

<div class="row">
<?php echo ListView::widget(
    [
        'dataProvider' => $dataProvider,
        'layout' => '<div class="row">{items}</div><div class="row">{pager}</div>',
        'itemView' => '_index_item',
        'itemOptions' => [
            'class' => 'col-md-4 col-sm-6',
            'tag' => 'article',
            'itemscope' => true,
            'itemtype' => 'http://schema.org/Person'
        ]
    ]
); ?>
</div>