<?php
    use yii\widgets\Breadcrumbs;
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
<?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页'],
    'links' => [
        ['label' => '用户管理', 'url' => ['index']]
    ]
])?>
<div class="inner-container">
    <?php if(Yii::$app->session->hasFlash('success')){?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?=Yii::$app->session->getFlash('success')?>
    </div>
    <?php }?>
    <?php if(Yii::$app->session->hasFlash('error')){?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?=Yii::$app->session->getFlash('error')?>
    </div>
    <?php }?>
    <p class="text-right">
        <a class="btn btn-primary btn-middle" href="<?=Url::to(['add'])?>">添加</a>
        <a id="delete-btn" class="btn btn-primary btn-middle">删除</a>
    </p>
    <?=Html::beginForm(['user/delete'], 'post', ['emctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'dltForm'])?>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked',this.checked);"></th>
                <th>用户名</th>
                <th>登录ip</th>
                <th>创建时间</th>
                <th>登录时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($models as $model): ?>
                <tr>
                    <td class="text-center"><input type="checkbox" name="selected[]" value="<?= $model->id;?>"></td>
                    <td><?= $model->username;?></td>
                    <td><?= $model->login_ip;?></td>
                    <td><?= date('Y-m-d H:i:s', $model->date);?></td>
                    <td><?= date('Y-m-d H:i:s', $model->login_date);?></td>
                    <td><?= $model->status == 1? '开启' : '禁用';?></td>
                    <td><a href="<?=Url::to(['update', 'id' => $model->id])?>" title="编辑" class="data_op data_edit"></a> |
                        <a href="javascript:void(0);" title="删除" class="data_op data_delete"></a></td>
                </tr>
            <?php endForeach;?>
            </tbody>
        </table>
    <?=Html::endForm()?>
    <?=\yii\widgets\LinkPager::widget([
        'pagination' => $pagination,
    ])?>
</div>
