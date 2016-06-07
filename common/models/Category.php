<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Category extends ActiveRecord
{
    public function rules()
    {
        return [
            ['pid', 'integer', 'min' => 0, 'tooSmall' => '不能小于0的整数', 'message' => '父类不能小于0'],
            ['name', 'required', 'message' => '父类名称不能为空'],
            ['name', 'string', 'max' => 30, 'tooLong' => '名称长度不能大于30位'],
            ['sort_order', 'integer', 'min' =>0, 'tooSmall' => '排序数值不能小于0', 'message' => '不能小于0的整数'],
            ['status', 'in', 'range' => [0,1], 'message' => '非法操作'],
            ['pid', 'checkPid']
        ];
    }

    public function checkPid($attributes, $params){
        if(self::find()->where(['pid'=>$this->id])->one()){
            $this->addError($attributes, '该类下有子类,请先移除!');
        }else if($this->id == $this->pid){
            $this->addError($attributes, '自己不能作为自己的父类!');
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)){
            if ($this->isNewRecord){
                $this->date = time();
            }
            return true;
        }
        return false;
    }

    public static function getParentCategoty(){
        $data = self::find()->where(['pid' => 0])->asArray()->all();
        return ArrayHelper::merge(['0' => '父类'], ArrayHelper::map($data, 'id','name'));

    }
    
    public static function deleteData($select)
    {
        return Category::deleteAll(['id' => $select]);
    }

}