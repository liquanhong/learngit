<?php
/**
 * Created by PhpStorm.
 * User: quanhong
 * Date: 2016/5/12
 * Time: 16:41
 */
namespace backend\controllers;

use yii\web\controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}