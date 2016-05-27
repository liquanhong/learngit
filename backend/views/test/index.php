<?php
/**
 * Created by PhpStorm.
 * User: quanhong
 * Date: 2016/5/12
 * Time: 16:42
 */
use yii\widgets\Breadcrumbs;
?>

<?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页', 'url' => ['site/index']],
    'itemTemplate' => '<li><b>{link}</b></li>',
    'links' => [
        ['label' => '用户列表', 'url' => ['user/index', 'id' => 13]],
        '添加用户'
    ],
])?>
