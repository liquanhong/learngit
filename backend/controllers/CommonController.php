<?php

namespace backend\controllers;

use yii;
use yii\web\Controller;
use backend\models\LoginForm;

class CommonController extends Controller
{
    public $user_id;
    public $username;

    public function init()
    {
        parent::init();
        if (!$this->getUserSession()){
            $loginForm = new LoginForm();
            if ($loginForm->loginByCookie()){
                $this->getUserSession();
            }
        }
    }

    private function getUserSession(){
        $session = Yii::$app->session;
        $this->user_id = Yii::$app->session->get(LoginForm::BACKEND_ID);
        $this->username = Yii::$app->session->get(LoginForm::BACKEND_USERNAME);
        return $this->user_id;
    }

}