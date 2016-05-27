<?php
	use backend\assets\LoginAsset;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Html;
	LoginAsset::register($this);
?>
   <div id="login_box">
   <h1>liqh后台登录</h1>
	   <?php $form = ActiveForm::begin('', 'post', ['id' => 'login-form']); ?>
		  <ul>
			 <li class="text">用户名：<?=Html::activeInput('text', $model, 'username',['class' => 'input'])?></li>
			 <li class="tip">&nbsp;<?=Html::error($model, 'username', ['class' => 'error'])?></li>
			 <li>密　码：<?=Html::activeInput('password', $model, 'password',['class' => 'input'])?></li>
			 <li class="tip">&nbsp;<?=Html::error($model, 'password', ['class' => 'error'])?></li>
			 <li style="position:relative;">验证码：<?=\yii\captcha\Captcha::widget([
					 'model' => $model,
					 'attribute' => 'verifyCode',
					 'captchaAction' => 'login/captcha',
					 'template' => '{input}{image}',
					 'options' => [
						 'class' => 'input verifycode',
						 'id' => 'verifyCode'
					 ]
				 ])?></li>
			 <li class="tip">&nbsp;<?=Html::error($model, 'verifyCode', ['class' => 'error'])?></li>
			 <li class="tip remember">
				 <?=Html::checkbox('LoginForm[remember]', false, ['id' => 'remember', 'value' => '1'])?>
				 <?=Html::label('保持登录状态', ['for' => "remember"])?>
			 </li>
		  </ul>
		  <div>
			  <?=Html::submitButton('登录', ['id'=>'login_submit'])?>
		  </div>
	   <?php ActiveForm::end(); ?>
   </div>