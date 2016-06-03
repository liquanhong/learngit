<?php
use yii\widgets\Breadcrumbs;
?>
<?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页'],
    'links' => [
        ['label' => '用户管理', 'url' => ['index']],
        ['label' => '修改用户', 'url' => ['add']]
    ]
])?>
<?=$this->render('_form',['model' => $model]);?>

