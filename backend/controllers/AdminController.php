<?php
/**
 * Created by PhpStorm.
 * User: quanhong
 * Date: 2016/5/16
 * Time: 14:05
 */
namespace backend\controllers;

use yii;
use backend\controllers\CommonController;

class AdminController extends CommonController
{
    public function init()
    {
        parent::init();
        if (!$this->user_id){
            return Yii::$app->response->redirect(['login/index']);
        }
    }

}