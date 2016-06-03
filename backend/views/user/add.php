<?php
use yii\widgets\Breadcrumbs;
?>
<?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页'],
    'links' => [
        ['label' => '用户管理', 'url' => ['index']],
        ['label' => '添加用户', 'url' => ['add']]
    ]
])?>
<?=$this->render('_form', ['model' => $model]);?>
