<?php
/**
 * Created by PhpStorm.
 * User: quanhong
 * Date: 2016/5/12
 * Time: 17:30
 */
namespace backend\controllers;

use backend\controllers\AdminController;
use common\models\User;
use yii\data\Pagination;
use yii;

class UserController extends AdminController
{
    public $layout = 'empty';
    public function actionIndex()
    {
        $query = User::find();
        $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => 5]);
        $models = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index', [
            'models' => $models,
            'pagination' => $pagination
        ]);
    }

    public function actionAdd()
    {
        $model = new User();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save())
        {
           Yii::$app->session->setFlash('success', '添加用户成功');
            return $this->redirect('index');
        }
        return $this->render('add', ['model' => $model]);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id', 0);
        $model = User::findOne($id);
        if(!$model)return $this->redirect('index');
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->session->setFlash('success', '修改用户成功');
            return $this->redirect('index');
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete()
    {
        $selected = Yii::$app->request->post('selected', []);
        if ($selected){
            $model = new User();
            if($model->deleteOne($selected)){
                Yii::$app->session->setFlash('success', '删除用户成功');
            }else{
                Yii::$app->session->setFlash('error', '删除用户失败');
            }
        }
        return $this->redirect('index');
    }

}