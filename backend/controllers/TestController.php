<?php
/**
 * Created by PhpStorm.
 * User: quanhong
 * Date: 2016/5/12
 * Time: 16:41
 */
namespace backend\controllers;

use yii\web\Controller;
use xj\uploadify\UploadAction;
use yii\imagine\image;
use yii;

class TestController extends Controller
{
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }

    public function actionIndex()
    {
//        $imagePath = '@backend/web/upload/a.jpg';
//        Image::crop('@backend/web/upload/a.jpg',600,400)
//            ->save(Yii::getAlias('@backend/web/upload/a-crop.jpg'),['quality'=>100]);
//        Image::thumbnail('@backend/web/upload/b.jpg',300,200)
//            ->save(Yii::getAlias('@backend/web/upload/b-thumbnail.jpg'), ['quality'=>100]);
//        $waterFile = '@backend/web/upload/a-thumbnail.jpg';
//        Image::watermark('@backend/web/upload/a.jpg',$waterFile)
//            ->save(Yii::getAlias('@backend/web/upload/1-water.jpg'), ['quality'=>100]);
//        $fontFile='@yii/captcha/SpicyRice.ttf';
//        Image::text('@backend/web/upload/a.jpg','liquanhong',$fontFile,[300,200], ['size'=>20,'color'=>'fefefe','angle'=>10])
//            ->save(Yii::getAlias('@backend/web/upload/1-text-100X100-f.jpg'), ['quality'=>100]);
        Image::frame('@backend/web/upload/a.jpg',40)
            ->save(Yii::getAlias('@backend/web/upload/a-frame.jpg'),['quality'=>100]);

        die;
        return $this->render('index');
    }
}