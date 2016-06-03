<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页'],
    'links' => [
        ['label' => '分类管理', 'url' => ['index']],
        ['label' => '修改文章分类', 'url' => ['add']]
    ]
])?>
<?= $this->render('_form', ['model' => $model]); ?>