<?php
namespace backend\controllers;

use backend\controllers\AdminController;
use common\models\Category;
use yii\data\Pagination;
use yii\web\Controller;


class CategoryController extends Controller
{
    public $layout = 'empty';

    public function actionIndex(){
        $query = Category::find();
        $pages = new Pagination(['totalCount' => $query->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index',[
           'models' => $models,
            'pages' => $pages,
        ]);
    }


    public function actionAdd(){
        $model = new Category();
        if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post())&& $model->validate() && $model->save()){
            \Yii::$app->session->setFlash('success', '添加文章分类成功');
            return $this->redirect(['index']);
        }
        return $this->render('add', ['model' => $model]);
    }

    public function actionUpdate($id){
        $id = (int)$id;
        $model = Category::findOne($id);
        if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post())&& $model->validate() && $model->save()){
            \Yii::$app->session->setFlash('success', '修改文章分类成功');
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete(){
        $select = \Yii::$app->request->post('selected');
        var_dump($select);
    }

}