<?php
    use yii\widgets\Breadcrumbs;
?>
<?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页'],
    'links' => [
        ['label' => '分类管理', 'url' => ['index']],
        ['label' => '添加文章分类', 'url' => ['add']]
    ]
])?>
<?= $this->render('_form', ['model' => $model]); ?>