<?php
namespace backend\controllers;

use backend\controllers\AdminController;
use backend\models\LoginForm;

class SiteController extends AdminController
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

    public function actionMain()
    {
        echo "123";
    }

    public function actionLayout(){
        $LoginForm = new LoginForm();
        $LoginForm->lagout();
        return $this->redirect(['login/index']);
    }

}
