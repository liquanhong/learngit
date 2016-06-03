<?php

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