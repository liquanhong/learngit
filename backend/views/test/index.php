<?php

use yii\widgets\Breadcrumbs;
use yii\web\JsExpression;
use yii\helpers\Html;
use xj\uploadify\Uploadify;

?>
<br>
<br>
<br>
<?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页', 'url' => ['site/index']],
    'itemTemplate' => '<li><b>{link}</b></li>',
    'links' => [
        ['label' => '用户列表', 'url' => ['user/index', 'id' => 13]],
        '添加用户'
    ],
])?>


<?=Html::fileInput('test', NULL, ['id' => 'test']); ?>
<?=Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
),
    'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        $('#a').append('<img src = '+ data.fileUrl +'>');
    }
}
EOF
),
   ]
]);
?>

<div id="a"></div>
