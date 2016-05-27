<?php
namespace common\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    const SUPER = 2;
    public function rules()
    {
        return [
            ['username', 'checkName', 'skipOnEmpty' => false],
            ['password', 'string', 'min' => 6, 'tooShort' => '密码长度不能少于6位', 'skipOnEmpty' => false,
            'when' => function($model){ return $model->isNewRecord || $model->password != '';}],
            ['status', 'in', 'range' => [0,1], 'message' => '非法操作']
        ];
    }

    public function checkName($attribute, $params)
    {
        if (!preg_match('/^[\w]{2,30}$/', $this->$attribute)){
            $this->addError($attribute, '用户名必须为2-30为数字或字母');
        }
        if($this->isNewRecord){
            if(self::find()->where(['username' => $this->$attribute])->count() > 0){
                $this->addError($attribute, '用户名已经被占用');
            }
        }else{
            if(self::find()->where(['username' => $this->$attribute])->andWhere(['!=', 'id', $this->id])->count() > 0){
                $this->addError($attribute, '用户名已经被占用');
            }
        }
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if ($this->isNewRecord){
                $this->date = $this->login_date = time();
                $this->login_ip = $_SERVER['REMOTE_ADDR'];
            }
            $this->login_date = time();
            $this->login_ip = $_SERVER['REMOTE_ADDR'];
            $this->password = md5($this->password);
            return true;
        }
        return false;
    }

    public function deleteOne($selected)
    {
        $data = [];
        foreach ($selected as $select){
            if($select == self::SUPER){
                return false;
            }else {
                $data[] = (int)$select;
            }
        }
        return self::deleteAll(['id' => $data]);
    }

}