<?php
/**
 * Created by PhpStorm.
 * User: quanhong
 * Date: 2016/5/13
 * Time: 14:31
 */
namespace backend\controllers;

use backend\models\LoginForm;
use backend\controllers\AdminController;
use yii;

class LoginController extends AdminController
{
    public $layout = 'empty';
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength'=>4,//生成验证码最大个数
                'minLength'=>4,//生成验证码最小个数
                'width'=>80,//验证码的宽度
                'height'=>40,//验证码的高度
            ]
        ];
    }

    public function actionIndex()
    {
        $model = new LoginForm();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate() && $model->login()) {
            return $this->redirect('/site/index');
        }
        return $this->render('index', ['model' => $model]);
    }
}